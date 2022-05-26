export type JW_ListBoxProps = {
  options: any[];
  label?: any;
  className?: string;
  index?: number;
  onItemSelectEvent?: (value: string, index: number) => void;
};
