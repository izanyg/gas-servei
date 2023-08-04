import { __ } from '@wordpress/i18n';

import { useBlockProps } from '@wordpress/block-editor';

export default function save(props) {
  const {attributes} = props;
  const cardImage = (src) => {
    if(!src) return null;

      return (
        <div 
          className="card__image" 
          style={{
              backgroundImage: "url(" + src + ")",

          }}>
          </div>
      );
  };
  
  return (
    <div { ...useBlockProps.save() }>
      <div className="card__content">
        <h2 className="card__title">{ attributes.title }</h2>
      </div>
    </div>
  );
}