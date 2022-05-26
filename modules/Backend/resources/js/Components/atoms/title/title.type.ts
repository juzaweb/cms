import { margin } from '../';
export type TextProps = {
  children: any;
  type: 'light' | 'dark';
  fontSize: number;
  fontSizeOnlyTablet: number;
  fontSizeOnlyMobile: number;
  fontWeight: number;
  fontWeightOnlyTablet: number;
  fontWeightOnlyMobile: number;
  margin: number[];
  color: Record<'r' | 'g' | 'b' | 'a', number> | any;
  align: 'left' | 'center' | 'right' | 'justify';
  style: React.CSSProperties;
  className?: string;
};

export const defaultPropsText = {
  type: 'light' as 'light' | 'dark',
  margin: [0, 0, 0, 0],
  fontSize: 4,
  fontSizeOnlyTablet: 0,
  fontSizeOnlyMobile: 0,
  fontWeight: 400,
  fontWeightOnlyTablet: 0,
  fontWeightOnlyMobile: 0,
  color: { r: 92, g: 90, b: 90, a: 1 },
  align: 'left' as 'left' | 'center' | 'right' | 'justify',
};
