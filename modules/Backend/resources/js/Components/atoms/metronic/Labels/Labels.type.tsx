export type LabelMTProps = {
  type: LabelTypes;
  className: string;
  children: any;
  style: React.CSSProperties;
  size: LabelSize;
  color: LabelColor;
  weight: LabelFontWeight;
};

export enum LabelTypes {
  CIRCLE,
  ROUNDED,
  SQUARE,
  INLINE,
  PILL,
}

export enum LabelSize {
  SM,
  MD,
  LG,
  XL,
}

export enum LabelColor {
  PRIMARY,
  SUCCESS,
  WARNING,
  DANGER,
  INFO,
  DARK,
  GRAY,

  OUTLINE_PRIMARY,
  OUTLINE_SUCCESS,
  OUTLINE_WARNING,
  OUTLINE_DANGER,
  OUTLINE_INFO,
  OUTLINE_DARK,

  LIGHT_PRIMARY,
  LIGHT_SUCCESS,
  LIGHT_WARNING,
  LIGHT_DANGER,
  LIGHT_INFO,
  LIGHT_DARK,

  DOT_PRIMARY,
  DOT_SUCCESS,
  DOT_WARNING,
  DOT_DANGER,
  DOT_INFO,
  DOT_DARK,
}

export enum LabelFontWeight {
  LIGHTER,
  LIGHT,
  NORMAl,
  BOLD,
  BOLDER,
  BOLDEST,
}
