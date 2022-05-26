export type ButtonProps = {
  typeButton: string;
  paddingVertical: number;
  paddingHorizontal: number;
  borderRadius: string;
  fontSize: number;
  fontWeight: number;
  pointed: string;
  href: string;
  children: any;
  className: string;
  id?: string;
  style: React.CSSProperties;
  action?: any;
  validate?: boolean;
  color?: string;
};

export type ButtonsProps = {
  typeButton: string;
  paddingVertical: number;
  paddingHorizontal: number;
  borderRadius: string;
  fontSize: number;
  fontWeight: number;
  pointed: string;
  children: any;
  className: string;
  style: React.CSSProperties;
  action?: any;
  validate?: boolean;
};
