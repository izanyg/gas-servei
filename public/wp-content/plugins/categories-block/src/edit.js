
import { __ } from '@wordpress/i18n';

import { useBlockProps, PlainText } from '@wordpress/block-editor';

import './editor.scss';

 
export default function Edit(props) {
  const {attributes, setAttributes} = props;
  const {title} = attributes;
	return (
    <>    
      <div {...useBlockProps()}>
        <PlainText 
              tagname="h2"
              placeholder="Escribe un título"
              className="card__title"
              value={title}
              onChange={ (newTitle) => setAttributes({title: newTitle}) }
            />
      </div>
    </>
	);
}
