export type TextProp = {
  fontSize: number;
  fontSizeOnlyTablet: number;
  fontSizeOnlyMobile: number;
  textAlign: string;
  fontWeight: number;
  fontWeightOnlyTablet: number;
  fontWeightOnlyMobile: number;
  color: Record<'r' | 'g' | 'b' | 'a', number>;
  shadow: number;
  text: string | number;
  margin: number[];
  style: React.CSSProperties;
  children: any;
  className?: string;
};
