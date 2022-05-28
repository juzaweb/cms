import React from 'react';
import cx from 'classnames';
import { AvatarProps } from './AvatarUser.type';

export const JW_Avatar = ({ className, src, centerAvatar }: AvatarProps) => {
  return (
    <div className={cx(['items-center flex', centerAvatar])}>
      <span
        className={`text-sm text-white bg-gray-300 inline-flex items-center justify-center rounded-full ${className}`}
      >
        <img
          alt="..."
          className="w-full rounded-full align-middle border-none shadow-lg"
          src={src}
        />
      </span>
    </div>
  );
};
