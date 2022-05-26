export type JW_BlockProps = {
  children: any;
  className: string;
  margin: number[];
  padding: number[];
  background: Record<'r' | 'g' | 'b' | 'a', number>;
  textAlign: string;
  style: React.CSSProperties;
  shadow: number;
  border: number;
  borderRadius: number;
  borderColor: Record<'r' | 'g' | 'b' | 'a', number>;
  position: string;
  width: string;
  height: string;
  maxWidth: string;
  maxHeight: string;
};
