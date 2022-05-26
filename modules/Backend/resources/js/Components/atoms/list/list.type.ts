export type listType = {
  className: string;
  listStyle: number;
  margin: number[];
  padding: number[];
  fontSize: number;
  color: Record<'r' | 'g' | 'b' | 'a', number>;
  backgroundColor: Record<'r' | 'g' | 'b' | 'a', number>;
  style: React.CSSProperties;
  children: any;
  fontWeight: number;
  fontSizeOnlyTablet: number;
  fontSizeOnlyMobile: number;
  fontWeightOnlyTablet: number;
  fontWeightOnlyMobile: number;
};
