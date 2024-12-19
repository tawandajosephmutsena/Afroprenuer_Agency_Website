import React, { useState } from 'react';
import { Badge } from "@/components/ui/badge";
import { Progress } from "@/components/ui/progress";
import { Calendar, Clock, Users, AlertCircle } from "lucide-react";

const ProjectCard = ({ project }) => {
    const [isExpanded, setIsExpanded] = useState(false);

    const getStatusColor = (status) => {
        const colors = {
            'planning': 'bg-yellow-100 text-yellow-800',
            'in_progress': 'bg-blue-100 text-blue-800',
            'on_hold': 'bg-red-100 text-red-800',
            'completed': 'bg-green-100 text-green-800',
        };
        return colors[status] || 'bg-gray-100 text-gray-800';
    };

    return (
        <div className="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200 overflow-hidden">
            <div className="p-4">
                {/* Header */}
                <div className="flex justify-between items-start mb-4">
                    <div>
                        <h3 className="text-lg font-semibold text-gray-900">{project.name}</h3>
                        {project.client && (
                            <div className="flex items-center text-sm text-gray-500 mt-1">
                                <Users className="w-4 h-4 mr-1" />
                                <span>{project.client.name}</span>
                            </div>
                        )}
                    </div>
                    <Badge className={getStatusColor(project.status)}>
                        {project.status.replace('_', ' ').toUpperCase()}
                    </Badge>
                </div>

                {/* Project Info */}
                <div className="space-y-4">
                    {(project.start_date || project.end_date) && (
                        <div className="flex items-center text-sm text-gray-600">
                            <Calendar className="w-4 h-4 mr-2" />
                            <span>{project.start_date} - {project.end_date || 'Ongoing'}</span>
                        </div>
                    )}

                    {/* Progress Bar */}
                    {typeof project.progress !== 'undefined' && (
                        <div className="space-y-1">
                            <div className="flex justify-between text-sm">
                                <span className="text-gray-600">Progress</span>
                                <span className="font-medium">{project.progress}%</span>
                            </div>
                            <Progress value={project.progress} className="h-2" />
                        </div>
                    )}

                    {/* Description */}
                    {project.description && (
                        <p className="text-sm text-gray-600 line-clamp-2">
                            {project.description}
                        </p>
                    )}

                    {/* Tasks Section */}
                    {project.tasks?.length > 0 && (
                        <div className="space-y-2">
                            <div className="flex justify-between items-center">
                                <span className="text-sm font-medium text-gray-900">
                                    Tasks ({project.tasks.length})
                                </span>
                                <button
                                    onClick={() => setIsExpanded(!isExpanded)}
                                    className="text-sm text-blue-600 hover:text-blue-800"
                                >
                                    {isExpanded ? 'Show Less' : 'Show More'}
                                </button>
                            </div>

                            {isExpanded && (
                                <div className="space-y-2 mt-2">
                                    {project.tasks.map(task => (
                                        <div
                                            key={task.id}
                                            className="p-2 bg-gray-50 rounded-md text-sm"
                                        >
                                            <div className="flex justify-between items-center">
                                                <span className="font-medium">{task.title}</span>
                                                <Badge className={getStatusColor(task.status)}>
                                                    {task.status}
                                                </Badge>
                                            </div>
                                            {task.due_date && (
                                                <div className="flex items-center text-gray-500 mt-1">
                                                    <Clock className="w-3 h-3 mr-1" />
                                                    Due: {task.due_date}
                                                </div>
                                            )}
                                        </div>
                                    ))}
                                </div>
                            )}
                        </div>
                    )}

                    {/* Notes Preview */}
                    {project.notes?.length > 0 && (
                        <div className="space-y-2">
                            <h4 className="text-sm font-medium text-gray-900">Latest Notes</h4>
                            {project.notes.slice(0, 2).map(note => (
                                <div
                                    key={note.id}
                                    className="text-sm text-gray-600 bg-gray-50 p-2 rounded-md"
                                >
                                    <p className="line-clamp-2">{note.content}</p>
                                    <span className="text-xs text-gray-500 mt-1">
                                        {note.created_at}
                                    </span>
                                </div>
                            ))}
                        </div>
                    )}
                </div>
            </div>

            {/* Footer */}
            <div className="px-4 py-3 bg-gray-50 border-t flex justify-between items-center">
                {project.tasks?.some(task => task.priority === 'urgent') && (
                    <div className="flex items-center text-red-600 text-sm">
                        <AlertCircle className="w-4 h-4 mr-1" />
                        <span>Has urgent tasks</span>
                    </div>
                )}
                <div className="flex space-x-2">
                    <a
                        href={`/admin/projects/${project.id}/edit`}
                        className="text-sm text-blue-600 hover:text-blue-800"
                    >
                        Edit
                    </a>
                    <button
                        className="text-sm text-blue-600 hover:text-blue-800"
                        onClick={() => window.location.href = `/admin/projects/${project.id}`}
                    >
                        View Details
                    </button>
                </div>
            </div>
        </div>
    );
};

export default ProjectCard;
