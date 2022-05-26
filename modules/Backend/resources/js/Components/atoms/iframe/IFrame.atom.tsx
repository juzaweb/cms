import React from 'react';
import { JW_FrameProps } from '.';

export const JW_Frame = ({
  src,
  width,
  height,
  scrolling,
  frameBorder,
  allowTransparency,
  allow,
}: Partial<JW_FrameProps>) => {
  return (
    <iframe
      src={src}
      width={width}
      height={height}
      scrolling={scrolling}
      style={{ border: 'none', overflow: 'hidden' }}
      frameBorder={frameBorder}
      allowTransparency={allowTransparency}
      allow={allow}
    ></iframe>
  );
};
