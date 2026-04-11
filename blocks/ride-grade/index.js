( function ( blocks, blockEditor, components, element, i18n ) {
	const { registerBlockType } = blocks;
	const { InspectorControls, useBlockProps } = blockEditor;
	const { PanelBody, SelectControl } = components;
	const { Fragment, createElement } = element;
	const { __ } = i18n;
	const el = createElement;
	const RIDE_GRADES = window.cycleChesterfieldRideGrades || {};

	const GRADE_OPTIONS = [
		{ label: __( 'Grade 1', 'cycle-chesterfield' ), value: '1' },
		{ label: __( 'Grade 2', 'cycle-chesterfield' ), value: '2' },
		{ label: __( 'Grade 3', 'cycle-chesterfield' ), value: '3' }
	];

	const getGradeData = ( grade ) => RIDE_GRADES[ grade ] || RIDE_GRADES[ '1' ] || {
		title: __( 'Grade 1 Ride', 'cycle-chesterfield' ),
		description: ''
	};

	const renderGradePreview = ( grade, className ) => {
		const gradeData = getGradeData( grade );

		return el(
			'div',
			{
				className
			},
			el(
				'strong',
				null,
				gradeData.title
			),
			el( 'p', null, gradeData.description )
		);
	};

	registerBlockType( 'cycle-chesterfield/ride-grade', {
		edit: ( props ) => {
			const { attributes, setAttributes } = props;
			const grade = attributes.grade || '1';
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
					renderGradePreview( grade, blockProps.className )
				);
		},
		save: () => null
	} );
} )( window.wp.blocks, window.wp.blockEditor, window.wp.components, window.wp.element, window.wp.i18n );
