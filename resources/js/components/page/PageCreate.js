import React, { useState, useRef } from 'react';

const PageCreate = () => {
    const [sections, setSections] = useState([
        { id: 'section-1', title: 'Section 1', content: [] },
    ]); // Initial state with one section

    const newSectionRef = useRef(null); // Reference for the new section placeholder

    const handleAddSection = () => {
        setSections((prevSections) => [
            { id: `section-${prevSections.length + 1}`, title: 'New Section', content: [] },
            ...prevSections,
        ]);
    };

    const renderSections = () =>
        sections.map((section) => (
            <Section key={section.id} title={section.title} content={section.content} />
        ));

    return (
        <div className="page-create">
            <h4>Create Page</h4>
            <div className="sections-container">
                {renderSections()}
                <div ref={newSectionRef} className="new-section-placeholder" />
            </div>
            <button type="button" onClick={handleAddSection}>
                Add Section
            </button>
        </div>
    );
};

const Section = ({ title, content }) => (
    <div className="section">
        <h2>{title}</h2>
        {/* Add your section content rendering logic here (images, text, etc.) */}
    </div>
);

export default PageCreate;
