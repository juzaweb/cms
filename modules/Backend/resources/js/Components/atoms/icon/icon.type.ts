export type IconProps = {
  classIcon: string;
  fontSize: number;
  fontSizeOnlyTablet: number;
  fontSizeOnlyMobile: number;
  fontWeight: number;
  fontWeightOnlyTablet: number;
  fontWeightOnlyMobile: number;
  color?: Record<'r' | 'g' | 'b' | 'a', number>;
  margin: number[];
  style: React.CSSProperties;
};
