import React, { useRef, useState, forwardRef, useImperativeHandle } from 'react';
import ReactQuill from 'react-quill';
import 'react-quill/dist/quill.snow.css'; // Import the Quill styles
import { Quill } from 'react-quill';

// Custom forwardRef to pass the Quill instance to the parent
interface QuillEditorProps {
    content: string;
    readOnly: boolean;
    onContentChange: (value: string) => void;
}

const QuillEditor = forwardRef(({ content, readOnly, onContentChange }: QuillEditorProps, ref) => {
    const quillRef = useRef(null); // Reference to access Quill instance

    useImperativeHandle(ref, () => ({
        getLength: () => quillRef.current?.getEditor().getLength(),
        getEditor: () => quillRef.current?.getEditor(),
    }));

    const handleChange = (value, delta, source, editor) => {
        onContentChange(value);
    };

    return (
            <ReactQuill
                className="rounded-lg"
                ref={quillRef}
                value={content}
                onChange={handleChange}
                readOnly={readOnly}
            />
    );
});

export default QuillEditor;
