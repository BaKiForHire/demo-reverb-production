import React, { useState, useRef } from 'react';

interface MediaUploaderProps {
    accept?: string;
    multiple?: boolean;
    onFilesChange: (files: File[]) => void;
}

const MediaUploader: React.FC<MediaUploaderProps> = ({ accept = 'image/*', multiple = false, onFilesChange }) => {
    const [files, setFiles] = useState<File[]>([]);
    const inputRef = useRef<HTMLInputElement | null>(null);

    const handleFiles = (selectedFiles: FileList | null) => {
        if (selectedFiles) {
            const newFiles = Array.from(selectedFiles);
            setFiles((prev) => [...prev, ...newFiles]);
            onFilesChange([...files, ...newFiles]);
        }
    };

    const handleDrop = (e: React.DragEvent<HTMLDivElement>) => {
        e.preventDefault();
        e.stopPropagation();
        handleFiles(e.dataTransfer.files);
    };

    const handleRemoveFile = (fileToRemove: File) => {
        const updatedFiles = files.filter((file) => file !== fileToRemove);
        setFiles(updatedFiles);
        onFilesChange(updatedFiles);
    };

    return (
        <div>
            <div
                className="border-2 border-dashed border-gray-300 p-6 rounded-md cursor-pointer hover:bg-gray-50"
                onClick={() => inputRef.current?.click()}
                onDragOver={(e) => e.preventDefault()}
                onDrop={handleDrop}
            >
                <input
                    ref={inputRef}
                    type="file"
                    accept={accept}
                    multiple={multiple}
                    className="hidden"
                    onChange={(e) => handleFiles(e.target.files)}
                />
                <p className="text-gray-500">Drag and drop files here, or click to select</p>
            </div>

            {/* File Preview */}
            {files.length > 0 && (
                <div className="mt-4 grid grid-cols-2 gap-4">
                    {files.map((file, idx) => (
                        <div key={idx} className="relative">
                            <img
                                src={URL.createObjectURL(file)}
                                alt={file.name}
                                className="w-full h-32 object-cover rounded-md shadow-sm"
                            />
                            <button
                                className="absolute top-1 right-1 bg-red-600 text-white p-1 rounded-full text-xs"
                                onClick={() => handleRemoveFile(file)}
                            >
                                &minus;
                            </button>
                        </div>
                    ))}
                </div>
            )}
        </div>
    );
};

export default MediaUploader;
