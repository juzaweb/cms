import React from 'react';
import cx from 'classnames';
import { SearchFormProps } from './SearchForm.type';

export const JW_SearchForm = ({
  className,
  placeholder = 'Search...',
  onChange,
  value,
  onSubmit,
}: Partial<SearchFormProps>) => {
  return (
    <form
      className={cx([
        className,
        'md:flex hidden flex-row flex-wrap items-center lg:ml-auto mr-3 rounded-full',
      ])}
      onSubmit={onSubmit}
    >
      <div className="relative flex w-full flex-wrap items-stretch">
        <span className="z-10 h-full leading-snug font-normal absolute text-center text-gray-400 bg-transparent rounded text-base items-center justify-center w-8 pl-6 py-2 ">
          <i className="fas fa-search"></i>
        </span>
        <input
          type="text"
          placeholder={placeholder}
          onChange={onChange}
          value={value}
          className="px-3 py-2 placeholder-gray-400 text-gray-700 relative rounded-full text-sm focus:outline-none w-full pl-10 bg-gray-100 ml-2"
        />
      </div>
    </form>
  );
};
