<?php

namespace common\models;


class CmsConfiguration extends ConfigModule
{
    protected $_module = 'cms';

    //posts
    public $postDefaultImage, $postEditor, $postEditorContentCss;
    public $postDuplicateTitlePrefix, $postDuplicateTitleSuffix, $postDuplicateStatus;
    //comments
    public $allowGuestComment, $commentModeration;
    //media
    public $mediaThumbSize;

    public function attributeLabels()
    {
        return [
	        'postDefaultImage' => 'Default Post Image',
            'postEditor' => 'Default Editor',
	        'postEditorContentCss' => 'Editor Content CSS',
            'postDuplicateTitlePrefix' => 'Duplicate Post Prefix',
            'postDuplicateTitleSuffix' => 'Duplicate Post Suffix',
            'postDuplicateStatus' => 'Duplicate Post Status',

            'allowGuestComment' => 'Allow Guest Comment',
            'commentModeration' => 'Comment Moderation',
            'mediaThumbSize' => 'Image Thumb Size',
        ];
    }

    public function attributeHints() {
		return [
			'postEditorContentCss' => 'enables to extend external css into the editable area',
	    ];
    }

    public function getAttributesMap()
    {
        return [
            'postDefaultImage' => 'post.default_image',
	        'postEditorContentCss' => 'post.editor.content_css',
            'allowGuestComment' => 'comment.allow_guest_comment',
            'commentModeration' => 'comment.moderation',
            'mediaThumbSize' => 'media.thumb_size',

            'postDuplicateTitlePrefix' => 'post.duplicate.title_prefix',
            'postDuplicateTitleSuffix' => 'post.duplicate.title_suffix',
            'postDuplicateStatus' => 'post.duplicate.status',
        ];
    }

    public function getpostEditorContentCss()
    {
	    return json_encode(explode("\n", $this->postEditorContentCss));
    }
}