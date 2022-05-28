export type ProgressBarMTProps = {
  valueNow: number;
  valueMin: number;
  valueMax: number;
  type: ProgressBarTypes;
  className: string;
  children: any;
  animation: boolean;
  striped: boolean;
  style: object;
};

export enum ProgressBarTypes {
  PRIMARY,
  SUCCESS,
  DANGER,
  WARNING,
}
