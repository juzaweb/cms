export type ButtonMTProps = {
  type: ButtonTypes;
  className: string;
  children: any;
  style: any;
};

export enum ButtonTypes {
  OUTLINE_PRIMARY,
  OUTLINE_SECONDARY,
  OUTLINE_SUCCESS,
  OUTLINE_DANGER,
  OUTLINE_WARNING,
  OUTLINE_INFO,
  OUTLINE_DARK,

  PRIMARY,
  SECONDARY,
  SUCCESS,
  DANGER,
  WARNING,
  INFO,
  DARK,
}
