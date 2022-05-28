import React from 'react';

export const JW_IconButton = ({ children, className = '', onClick }) => {
  return (
    <button
      onClick={onClick}
      className={`rounded-full shadow-lg bg-white p-2 flex items-center ${className}`}
    >
      {children}
    </button>
  );
};
