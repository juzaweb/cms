export type CardTypes = {};

export type CardVertical = {
  href: string;
  title: string;
  image: string;
  sumary: string;
  tag: string;
  width: string;
};

export const defaultCardVerticalProps = {
  href: '/',
  title: 'Default Props',
  image: '/star.svg',
  sumary: 'Content Sumary',
  tag: 'Default Content',
  width: '30%',
};
