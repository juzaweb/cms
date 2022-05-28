import { margin } from '../';

export type SectionContainer = {
  children: any;
  marginTop: margin;
  marginBottom: margin;
  paddingTop: margin;
  paddingBottom: margin;
};

export const defaultPropsContainer = {
  paddingTop: 10,
  paddingBottom: 10,
};

export const defaultPropsContainerBackgrourd = {
  paddingTop: 10,
  paddingBottom: 10,
  backgroundColor: 'rgba(255,255,255,0)',
};
export type ContainerBackgrourd = {
  backgroundColor: string;
  backgroundImage: string;
  children: React.ReactNode;
  marginTop: margin;
  marginBottom: margin;
  paddingTop: margin;
  paddingBottom: margin;
};
