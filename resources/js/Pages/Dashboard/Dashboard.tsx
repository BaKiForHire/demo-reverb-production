import { useEffect, useState } from 'react';
import axios from 'axios';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import Modal from '@/Components/Modal';
import Toast, { ToastType } from '@/Components/Toast';
import { BBBNotification } from '@/Icons/BBBIcons';
import TierForm from '@/Components/TierForm';
import LoadingSpinner from '@/Components/LoadingSpinner';
import { DashboardProps, Tier } from '@/types';
import DashboardSections from './Partials/DashboardSections';

export default function Dashboard(props: DashboardProps) {
    const { user, availableTiers, tierDetails } = props;
    const [showModal, setShowModal] = useState(false);
    const [selectedTier, setSelectedTier] = useState<Tier | null>(null);
    const [isLoading, setIsLoading] = useState(false);
    const [requiredKeys, setRequiredKeys] = useState<any[]>([]);
    const [formValues, setFormValues] = useState<{ [key: string]: any }>({});
    const [tierEvaluationLoading, setTierEvaluationLoading] = useState(false);
    const [toastMessages, setToastMessages] = useState<{ title: string; message: string, type: ToastType }[]>([]);
    const [submissionError, setSubmissionError] = useState(false);

    const showToast = (title: string, message: string, type: ToastType) => {
        setToastMessages((prev) => [...prev, { title, message, type }]);
    };

    const handleInputChange = (identifier: string, value: any) => {
        setFormValues((prev) => ({
            ...prev,
            [identifier]: value,
        }));
    };

    const handleTierSelection = async (tier: Tier) => {
        setSelectedTier(tier);
        setIsLoading(true);
        setShowModal(true);

        try {
            const response = await axios.get(route('tiers.keys', { tierId: tier.id }));
            const fetchedKeys = response.data;

            const initialFormValues: { [key: string]: any } = {};
            fetchedKeys.forEach((key: any) => {
                initialFormValues[key.identifier] = key.value || '';
            });

            setFormValues(initialFormValues);
            setRequiredKeys(fetchedKeys);
            setIsLoading(false);
        } catch (error) {
            console.error('Error fetching required keys:', error);
            setIsLoading(false);
        }
    };

    const handleFormSubmit = async () => {
        setIsLoading(true);
        let hasError = false;
        try {
            const promises = requiredKeys.map((key) => {
                const formData = new FormData();
                formData.append('user_tier_key_id', key.id);

                if (formValues[key.identifier] instanceof File) {
                    formData.append('value', formValues[key.identifier]);
                } else {
                    formData.append('value', formValues[key.identifier]);
                }

                return axios.post(route('tiers.key-values'), formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    },
                }).catch(error => {
                    hasError = true; // Mark that an error has occurred
                    const errorMessage = error.response?.data?.message || 'An error occurred while submitting the form.';
                    showToast('Error', errorMessage, ToastType.ERROR);
                    return null; // Return null for failed promises
                });
            });

            await Promise.all(promises);

            if (hasError) {
                setSubmissionError(true); // Set submission error state
                // Reset parent keys to false
                const updatedFormValues = { ...formValues };
                requiredKeys.forEach((key) => {
                    if (key.parent_key_id) {
                        updatedFormValues[requiredKeys.find(parent => parent.id === key.parent_key_id)?.identifier] = false;
                    }
                });
                setFormValues(updatedFormValues);
            } else {
                setIsLoading(false);
                setShowModal(false);
                showToast('Success', 'Your information has been successfully submitted & is being processed.', ToastType.SUCCESS);
                evaluateUserTiers([selectedTier.id]);
            }
        } catch (error) {
            console.error('Error submitting form:', error);
            setIsLoading(false);
            const errorMessage = error.response?.data?.message || 'An error occurred while submitting the form.';
            showToast('Error', errorMessage, ToastType.ERROR);
        } finally {
            setIsLoading(false);
        }
    };


    const evaluateUserTiers = async (tierIDs = [1, 2, 3]) => {
        setTierEvaluationLoading(true);
        try {
            await axios.post(route('tiers.evaluate'), {
                tier_ids: tierIDs,
            });
        } catch (error) {
            console.error('Tier evaluation failed:', error);
            showToast('Evaluation Failed', 'Tier evaluation failed.', ToastType.ERROR);
        } finally {
            setTierEvaluationLoading(false);
        }
    };

    useEffect(() => {
        if (user.tiers.length === 0) {
            showToast('Welcome!', 'You currently have no tiers. Complete your profile to start bidding or selling!', ToastType.INFO);
        }

        if (props.user && props.user.id) {
            const userId = props.user.id;
            const userChannel = window.Echo.channel(`user.${userId}`);

            userChannel.listen('.tier.upgraded', (event: any) => {
                console.log('[SOCKET] Tier Upgraded Event:', event);
                showToast('Tier Upgraded!', event.message, ToastType.SUCCESS);

                const existingTier = user.tiers.find((tier: Tier) => tier.id === event.tier_id);
                if (existingTier) {
                    existingTier.status = true;
                } else {
                    user.tiers.push({
                        ...availableTiers.find((tier: Tier) => tier.id === event.tier_id),
                        status: true
                    });
                }
                console.log("User now has tiers:", user.tiers);
            });

            userChannel.listen('.tier.evaluation.failed', (event: any) => {
                console.log('[SOCKET] Tier Evaluation Failed Event:', event);
                showToast('Tier Evaluation Failed', event.message, ToastType.WARNING);
            });

            return () => {
                userChannel.stopListening('.tier.upgraded');
                userChannel.stopListening('.tier.evaluation.failed');
            };
        }
    }, [props.user]);

    return (
        <AuthenticatedLayout
            user={user}
            header={
                <div className="flex justify-between items-end">
                    <h2 className="font-semibold text-xl text-gray-800 leading-tight py-6">Dashboard</h2>
                    <div className="hidden space-x-8 sm:-my-px sm:ms-10 custom-sm:flex">
                        {availableTiers.map((tier: Tier) => (
                            <div
                                key={tier.id}
                                className={
                                    "inline-flex py-6 items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out focus:outline-none cursor-pointer" +
                                    (user.tiers.some((userTier: Tier) => userTier.id === tier.id && userTier.status) ? ' border-[#78866b] text-gray-900' : user.tiers.some((userTier: Tier) => userTier.id === tier.id) ? ' border-[#ff9900] text-gray-900' : ' border-[#ff507a] text-gray-900')
                                }
                                onClick={() => {
                                    if (!user.tiers.some((userTier: Tier) => userTier.id === tier.id && userTier.status)) {
                                        handleTierSelection(tier);
                                    } else {
                                        showToast('Tier already owned', 'You already have this tier.', ToastType.INFO);
                                    }
                                }}
                            >
                                {tier.name}
                            </div>
                        ))}
                    </div>
                </div>
            }
        >
            <Head title="Dashboard" />

            {toastMessages.map((toast, index) => (
                <Toast
                    key={index}
                    title={toast.title}
                    message={toast.message}
                    type={toast.type}
                />
            ))}

            <div className="py-0">
                {user.tiers.length === 0 ? (
                    <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                            <div className="text-gray-900">
                                <p>You currently have no tiers. Complete your profile to start bidding or selling!</p>
                                <div className="mt-4 space-x-4">
                                    {availableTiers.map((tier: Tier) => (
                                        <button
                                            key={tier.id}
                                            className="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700"
                                            onClick={() => handleTierSelection(tier)}
                                        >
                                            Become a {tier.name}
                                        </button>
                                    ))}
                                </div>
                            </div>
                        </div>
                    </div>
                ) : (
                    <DashboardSections />
                )}
            </div>

            <Modal show={showModal} onClose={() => setShowModal(false)}>
                <div className="min-w-[300px] mx-auto">
                    {isLoading ? (
                        <LoadingSpinner />
                    ) : (
                        <div>
                            <h2 className="text-xl font-semibold">Complete Profile for {selectedTier?.name}</h2>
                            <TierForm
                                requiredKeys={requiredKeys}
                                formValues={formValues}
                                onInputChange={handleInputChange}
                                onSubmit={handleFormSubmit}
                                onError={submissionError}
                            />
                        </div>
                    )}
                </div>
            </Modal>
        </AuthenticatedLayout>
    );
}
