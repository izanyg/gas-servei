/**
 * Registers a new block provided a unique name and an object defining its behavior.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */
import { registerBlockType } from '@wordpress/blocks';

import './style.scss';

import Edit from './edit';
import save from './save';

registerBlockType( 'mimotic/categories-block', {
  attributes: {
    title: {
      source: "text",
      selector: ".card__title",
      default: "Título"
    },
  },
	edit: Edit,
	save,
} );
