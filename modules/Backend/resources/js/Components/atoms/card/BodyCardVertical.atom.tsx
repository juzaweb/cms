import React from 'react';

export const JW_BodyCardVertical = ({ title, sumary }) => {
  return (
    <React.Fragment>
      <div className="px-6 py-4">
        <div className="font-bold text-xl mb-2">{title}</div>
        <p className="text-gray-700 text-base">{sumary}</p>
      </div>
    </React.Fragment>
  );
};
