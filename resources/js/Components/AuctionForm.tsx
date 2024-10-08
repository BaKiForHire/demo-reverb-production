import React, { useRef, useState } from 'react';
import PrimaryButton from '@/Components/PrimaryButton';
import RadioGroup from '@/Components/RadioGroup';
import TextInput from '@/Components/TextInput';
import InputLabel from '@/Components/InputLabel';
import InputError from '@/Components/InputError';
import { useForm } from 'react-hook-form';
import QuillEditor from './QuillEditor';
import axios from 'axios';
import MediaUploader from './MediaUploader';

const AuctionForm = ({ auction }) => {
    const sections = ['Title & Listing Info', 'Photos & Details', 'Shipping/Payment Info'];
    const [currentStep, setCurrentStep] = useState(0);
    const watchFields = useForm().watch;
    const {
        register,
        handleSubmit,
        formState: { errors },
        watch,
        setValue,
    } = useForm({
        defaultValues: {
            title: auction?.title || '',
            description: auction?.description || '',
            start_price: auction?.start_price || '',
            reserve_price: auction?.reserve_price || '',
            buy_now_price: auction?.buy_now_price || '',
            can_make_offer: auction?.can_make_offer || 'false',
            is_auction: auction?.is_auction || 'true',
            start_time: auction?.start_time || '',
            end_time: auction?.end_time || '',
            location_id: auction?.location_id || '',
            category_id: auction?.category_id || '',
            shipping_methods: auction?.shipping_methods || '',
            payment_methods: auction?.payment_methods || '',
            sub_title: auction?.sub_title || '',
            media: null,
        },
    });

    const quillRef = useRef(null); // Quill editor reference
    const handleNextStep = () => {
        if (currentStep < sections.length - 1) setCurrentStep(currentStep + 1);
    };
    const handlePreviousStep = () => {
        if (currentStep > 0) setCurrentStep(currentStep - 1);
    };

    const isAuction = watch('is_auction') === 'true';
    const canMakeOffer = watch('can_make_offer') === 'true';

    const onSubmit = async (formData) => {
        try {
            const auctionId = auction ? route('auctions.update', {
                id: auction.id
            }) : route('auctions.store');
            const requestMethod = auction ? axios.put : axios.post;

            const payload = { ...formData };

            payload.media = {
                media_type: 'image',
                url: 'https://example.com/sample.jpg',
                alt_text: 'Sample image',
            };

            await requestMethod(auctionId, payload);
            alert('Auction submitted successfully!');
        } catch (error) {
            console.error('Error submitting auction form:', error);
        }
    };

    const optionsYesNo = [
        { label: 'Yes', value: 'true' },
        { label: 'No', value: 'false' },
    ];

    return (
        <div className="rounded-xl">
            <h2 className="text-xl font-bold mb-6">Enter Listing Details</h2> {/* Modal Heading */}
            <h4 className="text-md font-bold mb-2">{sections[currentStep]}</h4>
            <form onSubmit={handleSubmit(onSubmit)}>
                {/* Step 1: Title & Auction Info */}
                {currentStep === 0 && (
                    <>
                        <div className="mb-4">
                            <InputLabel htmlFor="title" value="Title" />
                            <TextInput
                                id="title"
                                name="title"
                                className="w-full rounded-lg text-gray-500 border-gray-300"
                                {...register('title', { required: 'Title is required' })}
                            />
                            <InputError message={errors.title?.message?.toString()} className="mt-2 text-red-500" />
                        </div>

                        <div className="mb-4">
                            <InputLabel htmlFor="category_id" value="Category" />
                            <TextInput
                                id="category_id"
                                name="category_id"
                                className="w-full rounded-lg text-gray-500 border-gray-300"
                                {...register('category_id', { required: 'Category is required' })}
                            />
                            <InputError message={errors.category_id?.message?.toString()} className="mt-2 text-red-500" />
                        </div>

                        <div className="mb-4">
                            <InputLabel htmlFor="sub_title" value="Sub Title" />
                            <TextInput
                                id="sub_title"
                                name="sub_title"
                                className="w-full rounded-lg text-gray-500 border-gray-300"
                                {...register('sub_title')}
                            />
                            <InputError message={errors.sub_title?.message?.toString()} className="mt-2 text-red-500" />
                        </div>

                        <div className="mb-4">
                            <InputLabel htmlFor="buy_now_price" value="Buy it Now Price" />
                            <TextInput
                                id="buy_now_price"
                                name="buy_now_price"
                                type="number"
                                min={0}
                                className="w-full rounded-lg text-gray-500 border-gray-300"
                                {...register('buy_now_price')}
                            />
                        </div>

                        <div className="mb-4">
                            <InputLabel htmlFor="description" value="Description" />
                            <QuillEditor
                                ref={quillRef}
                                content={watch('description')}
                                onContentChange={(content) => setValue('description', content)}
                                readOnly={false}
                            />
                            <InputError message={errors.description?.message?.toString()} className="mt-2 text-red-500" />
                        </div>
                    </>
                )}

                {/* Step 2: Photos */}
                {currentStep === 1 && (
                    <><div className="mb-4">
                        <InputLabel htmlFor="media" value="Upload Photos" />
                        <MediaUploader
                            onFilesChange={(files) => {
                                console.log('Files uploaded', files);
                            }}
                        />
                    </div>
                        <div className="flex gap-3 mb-4">
                            <div>
                                <InputLabel htmlFor="is_auction" value="Is this an Auction?" />
                                <RadioGroup
                                    name="is_auction"
                                    options={optionsYesNo}
                                    selectedValue={watch('is_auction')}
                                    onChange={(value) => setValue('is_auction', value)}
                                />

                            </div>
                            <div>
                                <InputLabel htmlFor="can_make_offer" value="Make Offer?" />
                                <RadioGroup
                                    name="can_make_offer"
                                    options={optionsYesNo}
                                    selectedValue={watch('can_make_offer')}
                                    onChange={(value) => setValue('can_make_offer', value)}
                                />
                            </div>
                        </div>

                        {isAuction && (
                            <>
                                <div className="mb-4">
                                    <InputLabel htmlFor="reserve_price" value="Reserve Price" />
                                    <TextInput
                                        id="reserve_price"
                                        name="reserve_price"
                                        type="number"
                                        min={0}
                                        className="w-full rounded-lg text-gray-500 border-gray-300"
                                        {...register('reserve_price', { required: 'Reserve price is required' })}
                                    />
                                    <InputError
                                        message={errors.reserve_price?.message?.toString()}
                                        className="mt-2 text-red-500"
                                    />
                                </div>

                                <div className="mb-4">
                                    <InputLabel htmlFor="start_price" value="Starting Price" />
                                    <TextInput
                                        id="start_price"
                                        name="start_price"
                                        type="number"
                                        min={0}
                                        className="w-full rounded-lg text-gray-500 border-gray-300"
                                        {...register('start_price', { required: 'Starting price is required' })}
                                    />
                                    <InputError
                                        message={errors.start_price?.message?.toString()}
                                        className="mt-2 text-red-500"
                                    />
                                </div>

                                <div className="mb-4">
                                    <InputLabel htmlFor="start_time" value="Start Time" />
                                    <TextInput
                                        id="start_time"
                                        name="start_time"
                                        type="datetime-local"
                                        className="w-full rounded-lg text-gray-500 border-gray-300"
                                        {...register('start_time', { required: 'Start time is required' })}
                                    />
                                    <InputError
                                        message={errors.start_time?.message?.toString()}
                                        className="mt-2 text-red-500"
                                    />
                                </div>

                                <div className="mb-4">
                                    <InputLabel htmlFor="end_time" value="End Time" />
                                    <TextInput
                                        id="end_time"
                                        name="end_time"
                                        type="datetime-local"
                                        className="w-full rounded-lg text-gray-500 border-gray-300"
                                        {...register('end_time', { required: 'End time is required' })}
                                    />
                                    <InputError
                                        message={errors.end_time?.message?.toString()}
                                        className="mt-2 text-red-500"
                                    />
                                </div>
                            </>
                        )}
                    </>
                )}

                {/* Step 4: Shipping & Payment */}
                {currentStep === 2 && (
                    <>
                        <div className="mb-4">
                            <InputLabel htmlFor="shipping_methods" value="Shipping Methods" />
                            <TextInput
                                id="shipping_methods"
                                name="shipping_methods"
                                className="w-full rounded-lg text-gray-500 border-gray-300"
                                {...register('shipping_methods', { required: 'Shipping methods are required' })}
                            />
                        </div>
                        <div className="mb-4">
                            <InputLabel htmlFor="payment_methods" value="Payment Methods" />
                            <TextInput
                                id="payment_methods"
                                name="payment_methods"
                                className="w-full rounded-lg text-gray-500 border-gray-300"
                                {...register('payment_methods', { required: 'Payment methods are required' })}
                            />
                        </div>
                    </>
                )}

                {/* Navigation buttons */}
                <div className="flex justify-between mt-6">
                    {currentStep > 0 && (
                        <button
                            type="button"
                            onClick={handlePreviousStep}
                            className="px-4 py-2 bg-white text-gray-700 border border-gray-400 rounded-lg hover:bg-gray-100"
                        >
                            Previous
                        </button>
                    )}
                    {currentStep < sections.length - 1 ? (
                        <PrimaryButton onClick={handleNextStep} className="px-4 py-2">
                            Next
                        </PrimaryButton>
                    ) : (
                        <PrimaryButton type="submit" className="bg-[#78866B]">
                            Submit Auction
                        </PrimaryButton>
                    )}
                </div>
            </form>
        </div>
    );
};

export default AuctionForm;
