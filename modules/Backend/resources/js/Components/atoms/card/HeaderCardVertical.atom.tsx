import React from 'react';
import { JW_ImageLazy } from '../image';

export const JW_HeaderCardVertical = ({ image }) => {
  return (
    <React.Fragment>
      <JW_ImageLazy
        width={374}
        height={228}
        src={image}
        alt="The Coldest Sunset"
      />
    </React.Fragment>
  );
};
