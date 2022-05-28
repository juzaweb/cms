import React from 'react';
import { JW_ProgressBarProps } from '.';

export const JW_ProgressBar = ({
  color,
  className,
  value,
}: Partial<JW_ProgressBarProps>) => {
  let barColor = '';

  if (value < 0 || value > 100) value = 0;

  if (value <= 25) barColor = 'bg-red';
  else if (value <= 50) barColor = 'bg-orange';
  else if (value <= 75) barColor = 'bg-teal';
  else barColor = 'bg-green';

  return (
    <React.Fragment>
      <div className={'flex items-center' + (className || '')}>
        <span className="mr-2">{value}%</span>
        <div className="relative w-full">
          <div
            className={
              'overflow-hidden h-2 text-xs flex rounded ' + barColor + '-200'
            }
          >
            <div
              style={{ width: value.toString() + '%', background: color }}
              className={
                'shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center ' +
                barColor +
                '-500 '
              }
            ></div>
          </div>
        </div>
      </div>
    </React.Fragment>
  );
};
