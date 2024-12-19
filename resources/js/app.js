import './bootstrap';
import React from 'react';
import { createRoot } from 'react-dom/client';
import '../css/app.css';

import ProjectCard from './Components/Filament/ProjectCard';
// FullCalendar imports
import FullCalendar from '@fullcalendar/react'; // Import FullCalendar
import dayGridPlugin from '@fullcalendar/daygrid'; // Import Day Grid plugin
import timeGridPlugin from '@fullcalendar/timegrid'; // Import Time Grid plugin
import interactionPlugin from '@fullcalendar/interaction'; // Import Interaction plugin



// Register React components for Filament
window.ReactComponents = {
    ProjectCard,
    FullCalendar, // Register FullCalendar component
};

// Function to mount React components
window.mountReactComponent = (component, element, props) => {
    if (!window.ReactComponents[component]) {
        console.error(`Component ${component} not found`);
        return;
    }

    const root = createRoot(element);
    const Component = window.ReactComponents[component];
    root.render(<Component {...props} />);
}

