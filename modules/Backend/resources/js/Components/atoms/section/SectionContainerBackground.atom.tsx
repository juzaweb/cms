import React from 'react';
import cx from 'classnames';
import {
  ContainerBackgrourd,
  defaultPropsContainerBackgrourd,
} from './section.type';

export const JW_SectionContainerBackgrourd = (
  props: Partial<ContainerBackgrourd>,
) => {
  props = {
    ...defaultPropsContainerBackgrourd,
    ...(props as any),
  };
  const {
    backgroundColor,
    backgroundImage,
    children,
    marginBottom,
    marginTop,
    paddingBottom,
    paddingTop,
  } = props;
  return (
    <section
      className={cx([
        'bg-no-repeat bg-cover bg-center relative',
        {
          'mt-0': marginTop === 0,
          'mt-1': marginTop === 1,
          'mt-2': marginTop === 2,
          'mt-3': marginTop === 3,
          'mt-4': marginTop === 4,
          'mt-5': marginTop === 5,
          'mt-6': marginTop === 6,
          'mt-8': marginTop === 8,
          'mt-10': marginTop === 10,
          'mt-12': marginTop === 12,
          'mt-16': marginTop === 16,
          'mt-20': marginTop === 20,
          'mt-24': marginTop === 24,
          'mt-32': marginTop === 32,
          'mt-40': marginTop === 40,
          'mt-48': marginTop === 48,
          'mt-56': marginTop === 56,
          'mt-64': marginTop === 64,
          'mt-auto': marginTop === 'auto',
        },
        {
          'mb-0': marginBottom === 0,
          'mb-1': marginBottom === 1,
          'mb-2': marginBottom === 2,
          'mb-3': marginBottom === 3,
          'mb-4': marginBottom === 4,
          'mb-5': marginBottom === 5,
          'mb-6': marginBottom === 6,
          'mb-8': marginBottom === 8,
          'mb-10': marginBottom === 10,
          'mb-12': marginBottom === 12,
          'mb-16': marginBottom === 16,
          'mb-20': marginBottom === 20,
          'mb-24': marginBottom === 24,
          'mb-32': marginBottom === 32,
          'mb-40': marginBottom === 40,
          'mb-48': marginBottom === 48,
          'mb-56': marginBottom === 56,
          'mb-64': marginBottom === 64,
          'mb-auto': marginBottom === 'auto',
        },
        {
          'pt-0': paddingTop === 0,
          'pt-1': paddingTop === 1,
          'pt-2': paddingTop === 2,
          'pt-3': paddingTop === 3,
          'pt-4': paddingTop === 4,
          'pt-5': paddingTop === 5,
          'pt-6': paddingTop === 6,
          'pt-8': paddingTop === 8,
          'pt-10': paddingTop === 10,
          'pt-12': paddingTop === 12,
          'pt-16': paddingTop === 16,
          'pt-20': paddingTop === 20,
          'pt-24': paddingTop === 24,
          'pt-32': paddingTop === 32,
          'pt-40': paddingTop === 40,
          'pt-48': paddingTop === 48,
          'pt-56': paddingTop === 56,
          'pt-64': paddingTop === 64,
          'pt-auto': paddingTop === 'auto',
        },
        {
          'pb-0': paddingBottom === 0,
          'pb-1': paddingBottom === 1,
          'pb-2': paddingBottom === 2,
          'pb-3': paddingBottom === 3,
          'pb-4': paddingBottom === 4,
          'pb-5': paddingBottom === 5,
          'pb-6': paddingBottom === 6,
          'pb-8': paddingBottom === 8,
          'pb-10': paddingBottom === 10,
          'pb-12': paddingBottom === 12,
          'pb-16': paddingBottom === 16,
          'pb-20': paddingBottom === 20,
          'pb-24': paddingBottom === 24,
          'pb-32': paddingBottom === 32,
          'pb-40': paddingBottom === 40,
          'pb-48': paddingBottom === 48,
          'pb-56': paddingBottom === 56,
          'pb-64': paddingBottom === 64,
          'pb-auto': paddingBottom === 'auto',
        },
      ])}
      style={{
        backgroundImage: `${
          backgroundImage ? `url(${backgroundImage})` : 'none'
        }`,
      }}
    >
      {/* <div className="block w-full h-full absolute inset-0 z-0 overflow-hidden">
          <JW_ImageLazy
            src={backgroundImage}
            alt={'website design'}
            width={'100%'}
            height={'100%'}
          />
        </div> */}
      <div
        className="block w-full h-full absolute inset-0 z-2"
        style={{ backgroundColor: backgroundColor }}
      ></div>
      <div className="container lg:px-8 mx-auto z-3 relative">{children}</div>
    </section>
  );
};
