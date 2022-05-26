import React from 'react';
import cx from 'classnames';
import { ButtonProps, ButtonsProps } from '.';

const defaultProps = {
  paddingVertical: 2,
  paddingHorizontal: 4,
  borderRadius: 'default',
  fontSize: 3,
  fontWeight: 1,
  typeButton: 'none-outline',
};

export const JW_Button = (props: Partial<ButtonProps>) => {
  props = {
    ...defaultProps,
    ...props,
  };

  const {
    typeButton,
    style,
    href,
    className,
    id,
    children,
    paddingHorizontal,
    paddingVertical,
    borderRadius,
    fontSize,
    fontWeight,
    pointed,
    action,
    color,
  } = props;

  return (
    <a
      href={href}
      style={style}
      className={cx([
        className,
        'inline-block items-center justify-center focus:outline-none focus:ring transition duration-150 ease-in-out cursor-pointer',
        {
          'py-0': paddingVertical === 0,
          'py-1': paddingVertical === 1,
          'py-2': paddingVertical === 2,
          'py-3': paddingVertical === 3,
          'py-4': paddingVertical === 4,
          'py-5': paddingVertical === 5,
          'py-6': paddingVertical === 6,
          'py-7': paddingVertical === 7,
          'py-8': paddingVertical === 8,
          'py-9': paddingVertical === 9,
          'py-10': paddingVertical === 10,
          'py-11': paddingVertical === 11,
          'py-12': paddingVertical === 12,
          'py-14': paddingVertical === 14,
          'py-16': paddingVertical === 16,
          'py-20': paddingVertical === 20,
          'py-24': paddingVertical === 24,
          'py-28': paddingVertical === 28,
          'py-32': paddingVertical === 32,
          'py-36': paddingVertical === 36,
          'py-40': paddingVertical === 40,
          'py-44': paddingVertical === 44,
          'py-48': paddingVertical === 48,
          'py-52': paddingVertical === 52,
          'py-56': paddingVertical === 56,
          'py-60': paddingVertical === 60,
          'py-64': paddingVertical === 64,
          'py-72': paddingVertical === 72,
          'py-80': paddingVertical === 80,
          'py-96': paddingVertical === 96,
        },
        {
          'px-0': paddingHorizontal === 0,
          'px-1': paddingHorizontal === 1,
          'px-2': paddingHorizontal === 2,
          'px-3': paddingHorizontal === 3,
          'px-4': paddingHorizontal === 4,
          'px-5': paddingHorizontal === 5,
          'px-6': paddingHorizontal === 6,
          'px-7': paddingHorizontal === 7,
          'px-8': paddingHorizontal === 8,
          'px-9': paddingHorizontal === 9,
          'px-10': paddingHorizontal === 10,
          'px-11': paddingHorizontal === 11,
          'px-12': paddingHorizontal === 12,
          'px-14': paddingHorizontal === 14,
          'px-16': paddingHorizontal === 16,
          'px-20': paddingHorizontal === 20,
          'px-24': paddingHorizontal === 24,
          'px-28': paddingHorizontal === 28,
          'px-32': paddingHorizontal === 32,
          'px-36': paddingHorizontal === 36,
          'px-40': paddingHorizontal === 40,
          'px-44': paddingHorizontal === 44,
          'px-48': paddingHorizontal === 48,
          'px-52': paddingHorizontal === 52,
          'px-56': paddingHorizontal === 56,
          'px-60': paddingHorizontal === 60,
          'px-64': paddingHorizontal === 64,
          'px-72': paddingHorizontal === 72,
          'px-80': paddingHorizontal === 80,
          'px-96': paddingHorizontal === 96,
        },
        {
          'rounded-none': borderRadius === 'none',
          'rounded-sm': borderRadius === 'sm',
          rounded: borderRadius === 'default',
          'rounded-md': borderRadius === 'md',
          'rounded-lg': borderRadius === 'lg',
          'rounded-xl': borderRadius === 'xl',
          'rounded-2xl': borderRadius === '2xl',
          'rounded-3xl': borderRadius === '3xl',
          'rounded-full': borderRadius === 'full',
        },
        {
          'text-xs': fontSize === 1,
          'text-sm': fontSize === 2,
          'text-base': fontSize === 3,
          'text-lg': fontSize === 4,
          'text-xl': fontSize === 5,
          'text-2xl': fontSize === 6,
          'text-3xl': fontSize === 7,
          'text-4xl': fontSize === 8,
          'text-5xl': fontSize === 9,
          'text-6xl': fontSize === 10,
        },
        {
          'font-hairline': fontWeight === 1,
          'font-thin': fontWeight === 2,
          'font-light': fontWeight === 3,
          'font-normal': fontWeight === 4,
          'font-medium': fontWeight === 5,
          'font-semibold': fontWeight === 6,
          'font-bold': fontWeight === 7,
          'font-extrabold': fontWeight === 8,
          'font-black': fontWeight === 9,
        },
        {
          'pointer-events-none': pointed === 'disable',
        },

        // {
        //   'border border-transparent text-white bg-purple-700 hover:bg-purple-800':
        //     typeButton === 'none-outline',
        //   'border border-purple-700 text-purple-700 hover:border-purple-700 hover:bg-purple-700 hover:text-white':
        //     typeButton === 'outline',
        // }
      ])}
      id={id}
      onClick={
        action
          ? action
          : (e) => {
              e.preventDefault();
            }
      }
    >
      {children}
    </a>
  );
};

export const JW_Buttons = (props: Partial<ButtonsProps>) => {
  props = {
    ...defaultProps,
    ...props,
  };

  const {
    typeButton,
    style,
    className,
    children,
    paddingHorizontal,
    paddingVertical,
    borderRadius,
    fontSize,
    fontWeight,
    pointed,
    action,
  } = props;

  return (
    <button
      style={style}
      className={cx([
        className,
        'inline-block items-center justify-center focus:outline-none focus:ring transition duration-150 ease-in-out cursor-pointer',
        {
          'py-0': paddingVertical === 0,
          'py-1': paddingVertical === 1,
          'py-2': paddingVertical === 2,
          'py-3': paddingVertical === 3,
          'py-4': paddingVertical === 4,
          'py-5': paddingVertical === 5,
          'py-6': paddingVertical === 6,
          'py-7': paddingVertical === 7,
          'py-8': paddingVertical === 8,
          'py-9': paddingVertical === 9,
          'py-10': paddingVertical === 10,
          'py-11': paddingVertical === 11,
          'py-12': paddingVertical === 12,
          'py-14': paddingVertical === 14,
          'py-16': paddingVertical === 16,
          'py-20': paddingVertical === 20,
          'py-24': paddingVertical === 24,
          'py-28': paddingVertical === 28,
          'py-32': paddingVertical === 32,
          'py-36': paddingVertical === 36,
          'py-40': paddingVertical === 40,
          'py-44': paddingVertical === 44,
          'py-48': paddingVertical === 48,
          'py-52': paddingVertical === 52,
          'py-56': paddingVertical === 56,
          'py-60': paddingVertical === 60,
          'py-64': paddingVertical === 64,
          'py-72': paddingVertical === 72,
          'py-80': paddingVertical === 80,
          'py-96': paddingVertical === 96,
        },
        {
          'px-0': paddingHorizontal === 0,
          'px-1': paddingHorizontal === 1,
          'px-2': paddingHorizontal === 2,
          'px-3': paddingHorizontal === 3,
          'px-4': paddingHorizontal === 4,
          'px-5': paddingHorizontal === 5,
          'px-6': paddingHorizontal === 6,
          'px-7': paddingHorizontal === 7,
          'px-8': paddingHorizontal === 8,
          'px-9': paddingHorizontal === 9,
          'px-10': paddingHorizontal === 10,
          'px-11': paddingHorizontal === 11,
          'px-12': paddingHorizontal === 12,
          'px-14': paddingHorizontal === 14,
          'px-16': paddingHorizontal === 16,
          'px-20': paddingHorizontal === 20,
          'px-24': paddingHorizontal === 24,
          'px-28': paddingHorizontal === 28,
          'px-32': paddingHorizontal === 32,
          'px-36': paddingHorizontal === 36,
          'px-40': paddingHorizontal === 40,
          'px-44': paddingHorizontal === 44,
          'px-48': paddingHorizontal === 48,
          'px-52': paddingHorizontal === 52,
          'px-56': paddingHorizontal === 56,
          'px-60': paddingHorizontal === 60,
          'px-64': paddingHorizontal === 64,
          'px-72': paddingHorizontal === 72,
          'px-80': paddingHorizontal === 80,
          'px-96': paddingHorizontal === 96,
        },
        {
          'rounded-none': borderRadius === 'none',
          'rounded-sm': borderRadius === 'sm',
          rounded: borderRadius === 'default',
          'rounded-md': borderRadius === 'md',
          'rounded-lg': borderRadius === 'lg',
          'rounded-xl': borderRadius === 'xl',
          'rounded-2xl': borderRadius === '2xl',
          'rounded-3xl': borderRadius === '3xl',
          'rounded-full': borderRadius === 'full',
        },
        {
          'text-xs': fontSize === 1,
          'text-sm': fontSize === 2,
          'text-base': fontSize === 3,
          'text-lg': fontSize === 4,
          'text-xl': fontSize === 5,
          'text-2xl': fontSize === 6,
          'text-3xl': fontSize === 7,
          'text-4xl': fontSize === 8,
          'text-5xl': fontSize === 9,
          'text-6xl': fontSize === 10,
        },
        {
          'font-hairline': fontWeight === 1,
          'font-thin': fontWeight === 2,
          'font-light': fontWeight === 3,
          'font-normal': fontWeight === 4,
          'font-medium': fontWeight === 5,
          'font-semibold': fontWeight === 6,
          'font-bold': fontWeight === 7,
          'font-extrabold': fontWeight === 8,
          'font-black': fontWeight === 9,
        },
        {
          'pointer-events-none': pointed === 'disable',
        },
        // {
        //   'border border-transparent text-white bg-purple-700 hover:bg-purple-800':
        //     typeButton === 'none-outline',
        //   'border border-purple-700 text-purple-700 hover:border-purple-700 hover:bg-purple-700 hover:text-white':
        //     typeButton === 'outline',
        // }
      ])}
      onClick={
        action
          ? action
          : (e) => {
              e.preventDefault();
            }
      }
    >
      {children}
    </button>
  );
};
