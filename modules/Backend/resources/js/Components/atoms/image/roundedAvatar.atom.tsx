import React from 'react';
import { RoundedAvatarProps } from './roundedAvatar.type';

export const RoundedAvatar = ({
  className = '',
  imgPath,
}: Partial<RoundedAvatarProps>) => {
  return (
    <React.Fragment>
      <img
        src={imgPath}
        alt="..."
        className={
          'w-10 h-10 rounded-full border-2 border-gray-100 shadow -ml-4 ' +
          className
        }
      />
    </React.Fragment>
  );
};
