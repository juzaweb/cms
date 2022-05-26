import React from 'react';

export const JW_Spinner = ({ className = '' }) => {
  return (
    <React.Fragment>
      <div className={`flex items-center justify-center ${className}`}>
        <svg
          className="spinner absolute z-50"
          width="65px"
          height="65px"
          viewBox="0 0 66 66"
        >
          <circle
            className="path absolute"
            fill="none"
            strokeWidth="6"
            strokeLinecap="round"
            cx="33"
            cy="33"
            r="30"
          ></circle>
        </svg>
      </div>
    </React.Fragment>
  );
};
