import React from 'react';
import LazyLoad from 'react-lazyload';
import { JW_ImageLazyProps } from '.';

export const JW_ImageLazy = (props: Partial<JW_ImageLazyProps>) => {
  const {
    width,
    height,
    src,
    alt,
    srcWebp,
    small,
    medium,
    large,
    smallWebp,
    mediumWebp,
    largeWebp,
    type,
    className = '',
  } = props;
  return (
    <LazyLoad width={width} height={height} offset={100} once>
      <picture>
        {srcWebp ? <source srcSet={srcWebp} type="image/webp" /> : null}
        {small ? (
          <source sizes="300w" srcSet={small} type={`image/${type}`} />
        ) : null}
        {medium ? (
          <source sizes="768w" srcSet={medium} type={`image/${type}`} />
        ) : null}
        {large ? (
          <source sizes="1280w" srcSet={large} type={`image/${type}`} />
        ) : null}
        {smallWebp ? (
          <source sizes="300w" srcSet={smallWebp} type="image/webp" />
        ) : null}
        {mediumWebp ? (
          <source sizes="768w" srcSet={mediumWebp} type="image/webp" />
        ) : null}
        {largeWebp ? (
          <source sizes="1280w" srcSet={largeWebp} type="image/webp" />
        ) : null}
        <img
          src={src}
          width={width}
          height={height}
          className={className ? `${className}` : `w-full ${className}`}
          alt={alt}
        />
      </picture>
    </LazyLoad>
  );
};
