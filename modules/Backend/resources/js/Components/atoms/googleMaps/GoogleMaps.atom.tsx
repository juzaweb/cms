import React from 'react';
import GoogleMapReact from 'google-map-react';
import { Map } from './googleMaps.type';
import { Marker } from './Marker.atom';

const defaultData = {
  APIKey: 'AIzaSyDgpNQi5_CTq0VuzRe8TsRlb9DPkHlhtCg',
  lat: 10.8422963,
  lng: 106.6745231,
  text: 'LofiVN',
  defaultZoom: 16,
  heightMap: '100%',
};

export const JW_GoogleMap = (props: Partial<Map>) => {
  props = {
    ...defaultData,
    ...props,
  };
  const { lat, lng, children, text, defaultZoom, APIKey, heightMap } = props;
  return (
    <div className={'w-full relative'} style={{ height: heightMap }}>
      <div
        className={'absolute z-2 inset-40-px bg-white w-2/4 p-4'}
        style={{ height: 'fit-content' }}
      >
        {children}
      </div>
      <GoogleMapReact
        bootstrapURLKeys={{ key: APIKey }}
        defaultZoom={defaultZoom}
        defaultCenter={{ lat: lat, lng: lng }}
      >
        <Marker lat={lat} lng={lng} text={text} />
      </GoogleMapReact>
    </div>
  );
};
