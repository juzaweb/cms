export const addScriptJS = (src: string, sync = 0, cdn = 0) => {
    const script = document.createElement('script');
    if (cdn !== 0) {
      script.src = src;
    } else {
      script.src = window.location.origin + src;
    }

    if (sync !== 0) {
      script.defer = true;
      script.async = true;
    } else {
      script.async = true;
    }
    return document.body.appendChild(script);
  };
