const Progress = ({ value = 0, className = '' }) => {
    return (
        <div className={`h-2 w-full overflow-hidden rounded-full bg-gray-200 ${className}`}>
            <div
                className="h-full bg-primary-600 transition-all duration-300"
                style={{ width: `${value}%` }}
            />
        </div>
    );
};

export { Progress };

