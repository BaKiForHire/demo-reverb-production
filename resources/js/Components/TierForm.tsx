import { useState, useEffect } from 'react';
import TextInput from '@/Components/TextInput';
import Checkbox from '@/Components/Checkbox';
import PrimaryButton from '@/Components/PrimaryButton';
import InputLabel from '@/Components/InputLabel';
import { BBBNotification } from '@/Icons/BBBIcons';
import SecondaryButton from './SecondaryButton';

type TierFormProps = {
    requiredKeys: any[];
    formValues: { [key: string]: any };
    onInputChange: (identifier: string, value: any) => void;
    onSubmit: () => void;
    onError?: boolean;
};


/**
 * A React component that renders a multi-step form for tiered data input.
 * 
 * @component
 * @param {TierFormProps} props - The properties for the TierForm component.
 * @param {Array} props.requiredKeys - An array of required keys for the form fields.
 * @param {Object} props.formValues - An object containing the current values of the form fields.
 * @param {Function} props.onInputChange - A callback function to handle input changes.
 * @param {Function} props.onSubmit - A callback function to handle form submission.
 * 
 * @returns {JSX.Element} The rendered TierForm component.
 * 
 * @example
 * const requiredKeys = [
 *   { id: 1, identifier: 'name', name: 'Name', data_type: 'string', required: true },
 *   { id: 2, identifier: 'age', name: 'Age', data_type: 'number', required: true },
 *   // more keys...
 * ];
 * 
 * const formValues = {
 *   name: '',
 *   age: '',
 *   // more values...
 * };
 * 
 * const handleInputChange = (identifier, value) => {
 *   // handle input change
 * };
 * 
 * const handleSubmit = () => {
 *   // handle form submission
 * };
 * 
 * <TierForm
 *   requiredKeys={requiredKeys}
 *   formValues={formValues}
 *   onInputChange={handleInputChange}
 *   onSubmit={handleSubmit}
 * />
 */
export default function TierForm({ requiredKeys, formValues, onInputChange, onSubmit, onError }: TierFormProps) {
    const [fieldsWithoutValues, setFieldsWithoutValues] = useState<any[]>([]);
    const [fieldsToRender, setFieldsToRender] = useState<any[]>([]);
    const [currentStep, setCurrentStep] = useState(0);
    const fieldsPerStep = 3; // Number of fields to display per step

    // Initial filter of fields based on pre-existing values
    useEffect(() => {
        const filteredKeys = requiredKeys.filter(key => {
            return (!formValues[key.identifier] || (key.data_type === "boolean" && key.value == "false")); // Only include fields that don't have values
        }); // Remove fields that already have values
        setFieldsWithoutValues(filteredKeys);
    }, [requiredKeys]); // Only runs when requiredKeys changes, not formValues

    // Initial filter of fields based on pre-existing values and conditions
    useEffect(() => {
        fieldsWithoutValues.forEach((key) => {
            // Check if the data type of the key is 'boolean' and the form value for this key is an empty string
            if (key.data_type === 'boolean' && formValues[key.identifier] === "") {
                // If both conditions are true, call the onInputChange function
                // to update the form value for this key to 'false'
                onInputChange(key.identifier, false);
            }
        });

        updateFieldsToRender();
    }, [formValues, fieldsWithoutValues]); // Re-run when formValues or requiredKeys change

    // Function to update fields to render based on parent conditions
    const updateFieldsToRender = () => {
        const filteredKeys = fieldsWithoutValues.filter(key => {
            // Check if the key has a parent and a condition
            if (key.parent_key_id) {
                const parentValue = formValues[fieldsWithoutValues.find(parent => parent.id === key.parent_key_id)?.identifier];
                return Boolean(parentValue) === Boolean(key.condition_value); // Only include if the condition matches
            }
            return true; // Always include fields without a parent condition
        });

        setFieldsToRender(filteredKeys);
    };

    // Reset parent keys if onError is true
    useEffect(() => {
        if (onError) {
            updateFieldsToRender();
        }
    }, [onError, requiredKeys]); // Runs only when onError or requiredKeys change

    const handleNextStep = () => {
        if (currentStep < Math.ceil(fieldsToRender.length / fieldsPerStep) - 1) {
            setCurrentStep(currentStep + 1);
        }
    };

    const handlePreviousStep = () => {
        if (currentStep > 0) {
            setCurrentStep(currentStep - 1);
        }
    };

    const handleFormSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        onSubmit();
    };

    const fieldsToShow = fieldsToRender.slice(currentStep * fieldsPerStep, currentStep * fieldsPerStep + fieldsPerStep);

    return (
        <form className="mt-4 space-y-4" onSubmit={handleFormSubmit}>
            {fieldsToShow.length === 0 && (
                <div className="text-center p-4 bg-[#78866b40] rounded-md">
                    <h2 className="text-xl font-semibold text-[#78866b]">All Set!</h2>
                    <p className="text-gray-700 mt-2">No additional data required for this tier. You can proceed to the next step or submit the form.</p>
                </div>
            ) || fieldsToShow.map((key) => {
                switch (key.data_type) {
                    case 'string':
                    case 'number':
                    case 'date':
                        return (
                            <div key={key.id}>
                                <InputLabel htmlFor={key.identifier} value={key.name} />
                                <TextInput
                                    className="mt-1 block w-full p-2 rounded-md border-gray-300 shadow-sm"
                                    id={key.identifier}
                                    type={key.data_type}
                                    name={key.identifier}
                                    value={formValues[key.identifier] || ''}
                                    onChange={(e) => onInputChange(key.identifier, e.target.value)}
                                    required={key.required}
                                />
                            </div>
                        );
                    case 'file':
                        return (
                            <div key={key.id}>
                                <InputLabel htmlFor={key.identifier} value={key.name} />
                                <input
                                    id={key.identifier}
                                    type="file"
                                    name={key.identifier}
                                    accept=".jpg,.png,.pdf"
                                    className="mt-1 block w-full p-2 rounded-md border-gray-300 shadow-sm"
                                    onChange={(e) => {
                                        if (e.target.files && e.target.files[0]) {
                                            onInputChange(key.identifier, e.target.files[0]);
                                        }
                                    }}
                                    required={key.required}
                                />
                            </div>
                        );
                    case 'boolean':
                        return (
                            <div key={key.id} className="flex items-center">
                                <Checkbox
                                    name={key.identifier}
                                    checked={formValues[key.identifier] === 'true'} // Convert the string to boolean for checked state
                                    onChange={(e) => {
                                        const newValue = e.target.checked ? 'true' : 'false'; // Convert the boolean to string
                                        onInputChange(key.identifier, newValue);
                                        // Trigger a re-evaluation of fields to render
                                        updateFieldsToRender();
                                    }}
                                />
                                <span className="ms-2 text-sm text-gray-600">{key.name}</span>
                            </div>
                        );
                    case 'dropdown':
                        const dropdownOptions = key.dropdown_values ? JSON.parse(key.dropdown_values) : [];
                        return (
                            <div key={key.id}>
                                <label className="block text-gray-700">{key.name}</label>
                                <select
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                    name={key.identifier}
                                    value={formValues[key.identifier] || ''}
                                    onChange={(e) => onInputChange(key.identifier, e.target.value)}
                                    required={key.required}
                                >
                                    <option value="">Select an option</option>
                                    {dropdownOptions.map((option: string, idx: number) => (
                                        <option key={idx} value={option}>{option}</option>
                                    ))}
                                </select>
                            </div>
                        );
                    default:
                        return null;
                }
            })}

            {/* Navigation Buttons */}
            <div className="flex justify-between mt-4">
                {currentStep > 0 && (
                    <SecondaryButton type="button" onClick={handlePreviousStep}>
                        Previous
                    </SecondaryButton>
                )}

                {currentStep < Math.ceil(fieldsToRender.length / fieldsPerStep) - 1 && (
                    <PrimaryButton type="button" onClick={handleNextStep}>
                        Next
                    </PrimaryButton>
                )}

                {(currentStep === Math.ceil(fieldsToRender.length / fieldsPerStep) - 1 || fieldsToShow.length == 0) && (
                    <PrimaryButton type="submit">
                        Submit
                    </PrimaryButton>
                )}
            </div>
        </form>
    );
}
