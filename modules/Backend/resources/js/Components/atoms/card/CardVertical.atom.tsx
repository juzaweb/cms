import React from 'react';
import {
  JW_HeaderCardVertical,
  JW_BodyCardVertical,
  JW_FooterCardVertical,
  CardVertical,
  defaultCardVerticalProps,
} from '.';
import { JW_Link } from '../';

export const JW_CardVertical = (props: Partial<CardVertical>) => {
  props = {
    ...defaultCardVerticalProps,
    ...props,
  };
  const { image, href, title, sumary, tag, width } = props;

  return (
    <React.Fragment>
      <div className="p-4 md:mb-0 mb-6 flex">
        <div
          className="flex-grow"
          style={{
            width: width ?? width,
          }}
        >
          <JW_Link href={href} title={title}>
            <JW_HeaderCardVertical image={image} />
          </JW_Link>
        </div>
        <div className="flex-grow pl-6">
          <JW_Link href={href} title={title}>
            <JW_BodyCardVertical title={title} sumary={sumary} />
          </JW_Link>
          <JW_FooterCardVertical tag={tag} />
        </div>
      </div>
    </React.Fragment>
  );
};
