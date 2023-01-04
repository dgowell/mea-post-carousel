/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps } from '@wordpress/block-editor';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';

import { useSelect } from '@wordpress/data';
/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */
import { RawHTML } from '@wordpress/element';
import Slider from 'react-slick';


export default function Edit() {
    const blockProps = useBlockProps();
    // Make the data request.
    const posts = useSelect((select) => {
        return select('core').getEntityRecords('postType', 'post');
    }, []);

    const settings = {
        dots: true,
        infinite: true,
        speed: 500,
        slidesToShow: 4,
        slidesToScroll: 1
    };

    return (
        <div {...useBlockProps()}>
            <Slider {...settings}>
                {posts && posts.map((post) => {
                    return (
                        <div key={post.id}>
                            <a href={post.link}>
                                <img src={post.featured_image_src} alt={post.title.raw} />
                                <div class="categories">{post.categories && post.categories.map((category) => {
                                    return (
                                        <p>{category}</p>
                                    )
                                })}</div>
                                {post.excerpt.rendered ? (
                                    <RawHTML>
                                        {post.excerpt.rendered}
                                    </RawHTML>
                                ) : (
                                    __('Default title', 'author-plugin')
                                )}
                            </a>
                        </div>
                    )
                })}
            </Slider>
        </div>
    );
}