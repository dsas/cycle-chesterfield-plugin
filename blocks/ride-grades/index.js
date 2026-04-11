( function ( blocks, blockEditor, element ) {
	const { registerBlockType } = blocks;
	const { useBlockProps } = blockEditor;
	const { createElement } = element;
	const el = createElement;
	const RIDE_GRADES = window.cycleChesterfieldRideGrades || {};

	const getGradeData = ( grade ) => RIDE_GRADES[ grade ] || RIDE_GRADES[ '1' ] || {
		title: 'Grade 1 Ride',
		description: ''
	};

	const renderGradePreview = ( grade, className ) => {
		const gradeData = getGradeData( grade );

		return el(
			'div',
			{
				className,
				key: grade
			},
			el(
				'strong',
				null,
				gradeData.title
			),
			el( 'p', null, gradeData.description )
		);
	};

	registerBlockType( 'cycle-chesterfield/ride-grades', {
		edit: () => {
			const blockProps = useBlockProps( {
				className: 'wp-block-cycle-chesterfield-ride-grades'
			} );

			return el(
				'div',
				blockProps,
				...Object.keys( RIDE_GRADES ).map( ( grade ) =>
					renderGradePreview(
						grade,
						'wp-block-cycle-chesterfield-ride-grades__item'
					)
				)
			);
		},
		save: () => null
	} );
} )( window.wp.blocks, window.wp.blockEditor, window.wp.element );
