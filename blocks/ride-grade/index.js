( function ( blocks, blockEditor, components, element, i18n ) {
	const { registerBlockType } = blocks;
	const { InspectorControls, useBlockProps } = blockEditor;
	const { PanelBody, SelectControl } = components;
	const { Fragment, createElement } = element;
	const { __ } = i18n;
	const el = createElement;

	const GRADE_DESCRIPTIONS = {
		'1': __( 'Mostly level ride on good surfaces, maybe some small hills, under 10 miles. Suitable for all', 'cycle-chesterfield' ),
		'2': __( 'Mostly level ride over 10 miles, some mixed surfaces, maybe some small hills OR a ride with several noticeable gradients / hills but under 10 miles. Suitable for riders with some experience and the ability to cycle over 10 miles or on several noticeable gradients / hills under 10 miles', 'cycle-chesterfield' ),
		'3': __( 'Any ride on mixed terrain with noticeable gradients / hills and over 10 miles. Suitable for the more experienced rider who can maintain an easy moderate pace throughout.', 'cycle-chesterfield' )
	};

	const GRADE_OPTIONS = [
		{ label: __( 'Grade 1', 'cycle-chesterfield' ), value: '1' },
		{ label: __( 'Grade 2', 'cycle-chesterfield' ), value: '2' },
		{ label: __( 'Grade 3', 'cycle-chesterfield' ), value: '3' }
	];

	registerBlockType( 'cycle-chesterfield/ride-grade', {
		edit: ( props ) => {
			const { attributes, setAttributes } = props;
			const grade = attributes.grade || '1';
			const description = GRADE_DESCRIPTIONS[ grade ] || GRADE_DESCRIPTIONS[ '1' ];
			const blockProps = useBlockProps( {
				className: 'wp-block-cycle-chesterfield-ride-grade'
			} );

			return el(
				Fragment,
				null,
				el(
					InspectorControls,
					null,
					el(
						PanelBody,
						{
							title: __( 'Ride Grade', 'cycle-chesterfield' ),
							initialOpen: true
						},
							el( SelectControl, {
								label: __( 'Grade', 'cycle-chesterfield' ),
								value: grade,
									options: GRADE_OPTIONS,
								onChange: ( value ) => setAttributes( { grade: value } )
							} )
						)
					),
				el(
					'div',
					blockProps,
							el(
								'strong',
								null,
								__( 'Grade ', 'cycle-chesterfield' ) + grade + ' ' + __( 'Ride', 'cycle-chesterfield' )
							),
						el( 'p', null, description )
					)
			);
		},
		save: () => null
	} );
} )( window.wp.blocks, window.wp.blockEditor, window.wp.components, window.wp.element, window.wp.i18n );
