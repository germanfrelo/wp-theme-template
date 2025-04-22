import { registerBlockType } from '@wordpress/blocks';
import Edit from './edit.js';
import './style.css';

registerBlockType('ifis/product-filter', {
  edit: Edit,
});
