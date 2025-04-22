import { __ } from '@wordpress/i18n';
import { PanelBody } from '@wordpress/components';
import { InspectorControls } from '@wordpress/block-editor';

export default function Edit() {
  return (
    <>
      <InspectorControls>
        <PanelBody title="Configuración del Filtro" initialOpen={ true }>
          <p>Este bloque muestra un filtro por categoría de producto en el frontend.</p>
        </PanelBody>
      </InspectorControls>
      <div className="wp-block-ifis-filtro-productos">
        <strong>{ __('Filtro de Productos (solo visible en el frontend)', 'ifis') }</strong>
      </div>
    </>
  );
}
