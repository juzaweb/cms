import React from 'react';
import { JW_BodyCardVertical } from './BodyCardVertical.atom';
import { JW_FooterCardVertical } from './FooterCardVertical.atom';
import { JW_HeaderCardVertical } from './HeaderCardVertical.atom';

export const JW_CardBox = ({ image, href, title, sumary, tag, category }) => {
  return (
    <React.Fragment>
      <a href={href}>
        <div className="max-w-sm rounded overflow-hidden shadow-lg">
          <JW_HeaderCardVertical image={image} />
          <JW_BodyCardVertical title={title} sumary={sumary} />
          <JW_FooterCardVertical tag={tag} />
        </div>
      </a>
    </React.Fragment>
  );
};
