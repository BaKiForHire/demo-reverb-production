import React from 'react';

interface RadioGroupProps {
    options: { label: string; value: string }[];
    name: string;
    selectedValue: string;
    onChange: (value: string) => void;
}

const RadioGroup: React.FC<RadioGroupProps> = ({ options, name, selectedValue, onChange }) => {
    return (
        <div className="flex flex-col space-y-2">
            {options.map((option) => (
                <label key={option.value} className="flex items-center space-x-2">
                    <input
                        type="radio"
                        name={name}
                        value={option.value}
                        checked={selectedValue === option.value}
                        onChange={() => onChange(option.value)}
                        className="form-radio text-blue-600"
                    />
                    <span>{option.label}</span>
                </label>
            ))}
        </div>
    );
};

export default RadioGroup;