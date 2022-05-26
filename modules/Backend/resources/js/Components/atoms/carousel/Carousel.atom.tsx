import React, { useEffect } from 'react';
import Slider from 'react-slick';
import { CarouselProps } from '.';
import { addScriptJS } from '../../../utils/common';

const defaultProps = {
  className: 'w-full',
  centerMode: true,
  infinite: true,
  centerPadding: '60px',
  slidesToShow: 3,
  loop: false,
  speed: 500,
};

export const JW_Carousel = (props: Partial<CarouselProps>) => {
  const { children } = props;

  props = {
    ...defaultProps,
    ...props,
  };

  useEffect(() => {
    addScriptJS(
      'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.min.css',
    );
    addScriptJS(
      'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick-theme.min.css',
    );
  });

  return (
    <React.Fragment>
      <Slider {...props}>{children}</Slider>
    </React.Fragment>
  );
};
