<?php

class SuperCarousel_Elements {

    public $elements = [];
    public $html = '';
    public $type;

    public function __construct($elements = []) {
        $this->elements = $elements;
    }

    public function getHtml() {
        $this->html = '';
        foreach ($this->elements as $i => $element) {
            if ($element->name == 'Image') {
                $this->html .= $this->getImageHtml($element, $i);
            } else if ($element->name == 'Title') {
                $this->html .= $this->getTitleHtml($element, $i);
            } else if ($element->name == 'HTML') {
                $this->html .= $this->getHtmlHtml($element, $i);
            } else if ($element->name == 'Optional Element') {
                $this->html .= $this->getOptionalElementHtml($element, $i);
            } else if ($element->name == 'Post Meta') {
                $this->html .= $this->getPostMetaHtml($element, $i);
            } else if ($element->name == 'Line') {
                $this->html .= $this->getHrHtml($element, $i);
            } else if ($element->name == 'Gap') {
                $this->html .= $this->getGapHtml($element, $i);
            } else if ($element->name == 'Button') {
                $this->html .= $this->getButtonHtml($element, $i);
            } else if ($element->name == 'Content') {
                $this->html .= $this->getContentHtml($element, $i);
            } else if ($element->name == 'Excerpt') {
                $this->html .= $this->getExcerptHtml($element, $i);
            } else if ($element->name == 'Categories') {
                $this->html .= $this->getCategoriesHtml($element, $i);
            } else if ($element->name == 'Description') {
                $this->html .= $this->getDescriptionHtml($element, $i);
            }
        }
        return $this->html;
    }

    function getButtonHtml($data = [], $i = 0) {
        $html = '<div class="super_buttonwrap super_buttonwrap' . $i . '">';
        $href = "javascript: void(0);";
        $clickaction = '';
        $lightboxaction = '';
        $lightboxclass = '';
        $target = ($data->prop->clickaction_target == 'New Window') ? '_blank' : '_self';
        if ($data->prop->clickaction == 'self_lightbox') {
            $href = '{lightboxurl}';
            $lightboxaction = ' data-src="{lightboxurl}" data-caption="{title}"';
            $lightboxclass = ' superlight';
        } else if (in_array($data->prop->clickaction, ['self_link', 'permalink', 'video_link', 'item_link', 'image_link'])) {
            $href = '{linkurl}';
        } else if ($data->prop->clickaction == 'custom_link') {
            $href = $data->prop->clickaction_link;
        } else if ($data->prop->clickaction == 'custom_function') {
            $clickaction = ' onclick="' . $data->prop->clickaction_callback . '"';
            $target = '';
        } else if ($data->prop->clickaction == 'featured_link') {
            $href = '{image_full}';
        } else if ($data->prop->clickaction == 'featured_lightbox') {
            $href = '{image_full}';
            $target = '';
            $lightboxaction = ' data-src="{image_full}" data-caption="{title}"';
            $lightboxclass = ' superlight';
        } else if (in_array($data->prop->clickaction, ['video_lightbox', 'image_lightbox'])) {
            $href = '{linkurl}';
            $target = '';
            $lightboxaction = ' data-src="{linkurl}" data-caption="{title}"';
            $lightboxclass = ' superlight';
        } else if ($this->type == 'Image') {
            $href = '{defaulthref}';
            $target = '{defaulttarget}';
            $lightboxaction = ' data-caption="{title}"';
        }
        $html .= '<a target="' . $target . '" href="' . $href . '"' . $clickaction . $lightboxaction . ' class="superbutton superelement' . $i . $lightboxclass . '" title="{title}">' . (isset($data->prop->label) ? $data->prop->label : '') . '</a>';
        $html .= '</div>';
        return $html;
    }

    function getGapHtml($data = [], $i = 0) {
        $html = '<div class="super_gap superelement' . $i . '"></div>';
        return $html;
    }

    function getHrHtml($data = [], $i = 0) {
        $html = '<div class="super_hr superelement' . $i . '"></div>';
        return $html;
    }

    function getOptionalElementHtml($data = [], $i = 0) {
        $html = '<div class="super_optelement superelement' . $i . '">';

        $html .= '{optionalelement|' . $data->prop->element_name . '}';

        $html .= '</div>';
        return $html;
    }

    function getTitleHtml($data = [], $i = 0) {
        $html = '<div class="super_title superelement' . $i . '">';

        $html .= $this->getClickActionStart($data);

        $html .= $this->getPrependString($data);

        $limit = $this->getStringLimit($data);

        $striptags = $this->getStripTagsFilter($data);

        $html .= "{title{$striptags}|stringlimit:{$limit}}";

        $html .= $this->getAppendString($data);

        $html .= $this->getClickActionEnd($data);

        $html .= '</div>';
        return $html;
    }

    function getHtmlHtml($data = [], $i = 0) {
        $html = '<div class="super_html superelement' . $i . '">';

        $html .= $this->getClickActionStart($data);

        $html .= $this->getPrependString($data);

        $limit = $this->getStringLimit($data);

        if (isset($data->prop)) {
            if (isset($data->prop->custom_html)) {
                $html .= $data->prop->custom_html;
            }
        }

        $html .= $this->getAppendString($data);

        $html .= $this->getClickActionEnd($data);

        $html .= '</div>';
        return $html;
    }

    function getPostMetaHtml($data = [], $i = 0) {
        $html = '<div class="super_postmeta superelement' . $i . '">';

        $limit = $this->getStringLimit($data);
        $striptags = $this->getStripTagsFilter($data);

        $html .= $this->getClickActionStart($data);
        $html .= $this->getPrependString($data);
        $html .= '{postmeta|postmeta:' . $data->prop->post_meta . $striptags . '|stringlimit:' . $limit . '}';
        $html .= $this->getAppendString($data);
        $html .= $this->getClickActionEnd($data);

        $html .= '</div>';
        return $html;
    }

    function getDescriptionHtml($data = [], $i = 0) {
        $html = '<div class="super_description superelement' . $i . '">';
        $html .= $this->getClickActionStart($data);
        $html .= $this->getPrependString($data);
        $limit = $this->getStringLimit($data);
        $striptags = $this->getStripTagsFilter($data);
        $html .= "{description{$striptags}|stringlimit:{$limit}}";
        $html .= $this->getAppendString($data);
        $html .= $this->getClickActionEnd($data);
        $html .= '</div>';
        return $html;
    }

    function getExcerptHtml($data = [], $i = 0) {
        $html = '<div class="super_excerpt superelement' . $i . '">';
        $html .= $this->getClickActionStart($data);
        $html .= $this->getPrependString($data);
        $limit = $this->getStringLimit($data);
        $striptags = $this->getStripTagsFilter($data);
        $html .= "{excerpt{$striptags}|stringlimit:{$limit}}";
        $html .= $this->getAppendString($data);
        $html .= $this->getClickActionEnd($data);
        $html .= '</div>';
        return $html;
    }

    function getCategoriesHtml($data = [], $i = 0) {
        $html = '<div class="super_categories superelement' . $i . '">';
        $html .= "{categories}";
        $html .= '</div>';
        return $html;
    }

    function getContentHtml($data = [], $i = 0) {
        $html = '<div class="super_content superelement' . $i . '">';
        $html .= $this->getClickActionStart($data);
        $html .= $this->getPrependString($data);
        $limit = $this->getStringLimit($data);
        $striptags = $this->getStripTagsFilter($data);
        $html .= "{content{$striptags}|stringlimit:{$limit}}";
        $html .= $this->getAppendString($data);
        $html .= $this->getClickActionEnd($data);
        $html .= '</div>';
        return $html;
    }

    public function getImageHtml($data = [], $i = 0) {
        $html = '<div class="super_imagewrap">';

        if (isset($data->elements) and is_array($data->elements) and count($data->elements) > 0) {
            $html .= $this->getOverLayElements($data->elements, $i);
        } else {
            $html .= '<div class="super_overlay super_overlay' . $i . '"></div>';
        }

        $html .= $this->getClickActionStart($data);

        $html .= '<img src="{image_' . $this->getImageSize($data) . '}" alt="{altimage}" title="{titleimage}" class="super_image superelement' . $i . '" />';

        $html .= $this->getClickActionEnd($data);

        $html .= '</div>';
        return $html;
    }

    public function getStringLimit(&$data) {
        $return = 0;
        if (isset($data->prop)) {
            if (isset($data->prop->string_limit)) {
                $return = (int) $data->prop->string_limit;
            }
        }
        return $return;
    }

    public function getStripTagsFilter(&$data) {
        $return = '';
        if (isset($data->prop)) {
            if (isset($data->prop->strip_tags)) {
                if ($data->prop->strip_tags == 'yes') {
                    $return = '|striptags';
                }
            }
        }
        return $return;
    }

    public function getPrependString(&$data) {
        $return = '';
        if (isset($data->prop)) {
            if (isset($data->prop->string_prepend)) {
                $return = $data->prop->string_prepend;
            }
        }
        return $return;
    }

    public function getAppendString(&$data) {
        $return = '';
        if (isset($data->prop)) {
            if (isset($data->prop->string_append)) {
                $return = $data->prop->string_append;
            }
        }
        return $return;
    }

    public function getClickActionStart(&$data) {
        $return = '';
        if (isset($data->prop)) {
            if (isset($data->prop->clickaction)) {
                $target = ($data->prop->clickaction_target == 'New Window') ? '_blank' : '_self';
                if ($data->prop->clickaction == 'self_lightbox') {
                    $return .= '<a href="{lightboxurl}" data-caption="{titleimage}" target="_self" class="super_clickaction superlight" title="{titleimage}">';
                } else if ($data->prop->clickaction == 'custom_link') {
                    $return .= '<a target="' . $target . '" href="' . $data->prop->clickaction_link . '" class="super_clickaction" title="{titleimage}">';
                } else if ($data->prop->clickaction == 'custom_function') {
                    $return .= '<a href="javascript: void(0);" onclick="' . $data->prop->clickaction_callback . '" target="" class="" title="{titleimage}">';
                } else if (in_array($data->prop->clickaction, ['permalink', 'video_link', 'item_link', 'image_link', 'self_link'])) {
                    $return .= '<a target="' . $target . '" href="{linkurl}" class="super_clickaction" title="{titleimage}">';
                } else if ($data->prop->clickaction == 'featured_link') {
                    $return .= '<a target="' . $target . '" href="{image_full}" class="super_clickaction" title="{titleimage}">';
                } else if ($data->prop->clickaction == 'featured_lightbox') {
                    $return .= '<a href="{image_full}" data-src="{image_full}" data-caption="{titleimage}" class="super_clickaction superlight" title="{titleimage}">';
                } else if (in_array($data->prop->clickaction, ['video_lightbox', 'image_lightbox'])) {
                    $return .= '<a href="{linkurl}" data-src="{linkurl}" data-caption="{titleimage}" class="super_clickaction superlight" title="{titleimage}">';
                } else if ($data->prop->clickaction == 'item_lightbox') {
                    $return .= '<a href="{image_large}" class="super_clickaction superlight" data-caption="{title}" title="{titleimage}">';
                } else if ($this->type == 'Image') {
                    $return .= '<a href="{defaulthref}" target="{defaulttarget}" data-caption="{titleimage}" class="super_clickaction" title="{titleimage}">';
                }
            }
        }
        return $return;
    }

    public function getClickActionEnd(&$data) {
        $return = '';
        if (isset($data->prop)) {
            if (isset($data->prop->clickaction)) {
                if (in_array($data->prop->clickaction, ['self_link', 'self_lightbox', 'custom_link', 'custom_function', 'permalink', 'featured_link', 'featured_lightbox', 'video_link', 'video_lightbox', 'item_link', 'item_lightbox', 'image_link', 'image_lightbox'])) {
                    $return .= '</a>';
                } else if ($this->type == 'Image') {
                    $return .= '</a>';
                }
            }
        }
        return $return;
    }

    public function getOverLayElements($data = [], $k = 0) {
        $html = '<div class="super_overlay super_overlay' . $k . '">';
        //$html = '';
        foreach ($data as $i => $element) {

            $limit = $this->getStringLimit($element);
            $striptags = $this->getStripTagsFilter($data);

            if ($element->name == 'Overlay Title') {

                $html .= '<div class="super_overlay_title superoverlayelement' . $i . '">';
                $html .= $this->getClickActionStart($element);
                $html .= $this->getPrependString($element);
                $html .= '{title' . $striptags . '|stringlimit:' . $limit . '}';
                $html .= $this->getAppendString($element);
                $html .= $this->getClickActionEnd($element);
                $html .= '</div>';
            } else if ($element->name == 'Overlay HTML') {

                $html .= '<div class="super_overlay_html superoverlayelement' . $i . '">';
                $html .= $this->getClickActionStart($element);
                $html .= $this->getPrependString($element);
                if (isset($element->prop)) {
                    if (isset($element->prop->custom_html)) {
                        $html .= $element->prop->custom_html;
                    }
                }
                $html .= $this->getAppendString($element);
                $html .= $this->getClickActionEnd($element);
                $html .= '</div>';
            } else if ($element->name == 'Overlay Excerpt') {

                $html .= '<div class="super_overlay_excerpt superoverlayelement' . $i . '">';
                $html .= $this->getClickActionStart($element);
                $html .= $this->getPrependString($element);
                $html .= '{excerpt' . $striptags . '|stringlimit:' . $limit . '}';
                $html .= $this->getAppendString($element);
                $html .= $this->getClickActionEnd($element);
                $html .= '</div>';
            } else if ($element->name == 'Overlay Post Meta') {
                $html .= '<div class="super_overlay_postmeta superoverlayelement' . $i . '">';
                $html .= $this->getClickActionStart($element);
                $html .= $this->getPrependString($element);
                $html .= '{postmeta|postmeta:' . $element->prop->post_meta . $striptags . '|stringlimit:' . $limit . '}';
                $html .= $this->getAppendString($element);
                $html .= $this->getClickActionEnd($element);
                $html .= '</div>';
            } else if ($element->name == 'Overlay Optional Element') {
                $html .= '<div class="super_overlay_optelement superoverlayelement' . $i . '">{optionalelement|' . $element->prop->element_name . '}</div>';
            }
        }
        $html .= '</div>';
        return $html;
    }

    public function getImageSize($data = []) {
        if (isset($data->prop)) {
            if (isset($data->prop->image_size)) {
                return $data->prop->image_size;
            }
        }

        return 'large';
    }

}
