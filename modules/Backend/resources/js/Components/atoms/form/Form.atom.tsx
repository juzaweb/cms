import React from 'react';
import {JW_Field} from "../field";

export const JW_Form = ({ options = {
    action: '',
    onSubmit: undefined
}, children = [] }) => {
  return (
    <React.Fragment>
      <form action={options.action} onSubmit={options.onSubmit}>
          <JW_Field fields={children}/>
      </form>
    </React.Fragment>
  );
};
