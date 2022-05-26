import React from 'react';
import ReactPaginate from 'react-paginate';
import { PaginationProps } from './pagination.type';

export const JW_Pagination = (props: Partial<PaginationProps>) => {
  const styles =
    'flex items-center w-9 h-9 justify-center mx-1 rounded bg-gray-100 text-base text-gray-700 hover:bg-blue-500 hover:text-white cursor-pointer focus:outline-none';
  return (
    <ReactPaginate
      pageCount={props.pageCount}
      onPageChange={props.handlePageClick}
      marginPagesDisplayed={2}
      pageRangeDisplayed={5}
      previousLabel={<i className="fas fa-chevron-left"></i>}
      nextLabel={<i className="fas fa-chevron-right"></i>}
      breakLabel={'...'}
      breakClassName={'break-me'}
      previousClassName={styles}
      nextClassName={styles}
      pageLinkClassName={styles}
      containerClassName={'flex flex-row'}
      activeLinkClassName={'bg-blue-500 important-text-white'}
    />
  );
};
