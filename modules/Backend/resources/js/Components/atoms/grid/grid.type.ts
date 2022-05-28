import { margin } from '.';
export type GirdProps = {
  children: any;
  col: number;
  marginTop: margin;
  marginBottom: margin;
  color: Record<'r' | 'g' | 'b' | 'a', number>;
  style: React.CSSProperties;
};
