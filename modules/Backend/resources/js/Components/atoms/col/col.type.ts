import { margin } from '../grid';

export type ColProps = {
  children: any;
  col: number;
  mobile?: number;
  tablet?: number;
  className?: string;
  marginLeft: margin;
  marginRight: margin;
  paddingTop: margin;
  paddingBottom: margin;
  paddingVertical: margin;
  color: Record<'r' | 'g' | 'b' | 'a', number>;
  style: React.CSSProperties;
};
