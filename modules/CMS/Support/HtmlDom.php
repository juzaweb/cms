<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Support;

class HtmlDom
{
    public ?HtmlDomNode $root = null;
    public $nodes = array();
    public $callback = null;
    public $lowercase = false;
    public $original_size;
    public $size;
    public $_charset = '';
    public $_target_charset = '';
    public $default_span_text = '';
    protected $pos;
    protected $doc;
    protected $char;
    protected $cursor;
    protected $parent;
    protected $noise = array();
    protected $token_blank = " \t\r\n";
    protected $token_equal = ' =/>';
    protected $token_slash = " />\r\n\t";
    protected $token_attr = ' >';
    protected $default_br_text = '';
    protected $self_closing_tags = array(
        'area' => 1,
        'base' => 1,
        'br' => 1,
        'col' => 1,
        'embed' => 1,
        'hr' => 1,
        'img' => 1,
        'input' => 1,
        'link' => 1,
        'meta' => 1,
        'param' => 1,
        'source' => 1,
        'track' => 1,
        'wbr' => 1
    );
    protected $block_tags = array(
        'body' => 1,
        'div' => 1,
        'form' => 1,
        'root' => 1,
        'span' => 1,
        'table' => 1
    );
    protected $optional_closing_tags = array(
        // Not optional, see
        // https://www.w3.org/TR/html/textlevel-semantics.html#the-b-element
        'b' => array('b' => 1),
        'dd' => array('dd' => 1, 'dt' => 1),
        // Not optional, see
        // https://www.w3.org/TR/html/grouping-content.html#the-dl-element
        'dl' => array('dd' => 1, 'dt' => 1),
        'dt' => array('dd' => 1, 'dt' => 1),
        'li' => array('li' => 1),
        'optgroup' => array('optgroup' => 1, 'option' => 1),
        'option' => array('optgroup' => 1, 'option' => 1),
        'p' => array('p' => 1),
        'rp' => array('rp' => 1, 'rt' => 1),
        'rt' => array('rp' => 1, 'rt' => 1),
        'td' => array('td' => 1, 'th' => 1),
        'th' => array('td' => 1, 'th' => 1),
        'tr' => array('td' => 1, 'th' => 1, 'tr' => 1),
    );

    public function __construct(
        $str = null,
        $lowercase = true,
        $forceTagsClosed = true,
        $target_charset = DEFAULT_TARGET_CHARSET,
        $stripRN = true,
        $defaultBRText = DEFAULT_BR_TEXT,
        $defaultSpanText = DEFAULT_SPAN_TEXT,
        $options = 0
    ) {
        if ($str) {
            if (preg_match('/^http:\/\//i', $str) || is_file($str)) {
                $this->load_file($str);
            } else {
                $this->load(
                    $str,
                    $lowercase,
                    $stripRN,
                    $defaultBRText,
                    $defaultSpanText,
                    $options
                );
            }
        }
        // Forcing tags to be closed implies that we don't trust the html, but
        // it can lead to parsing errors if we SHOULD trust the html.
        if (!$forceTagsClosed) {
            $this->optional_closing_array = array();
        }

        $this->_target_charset = $target_charset;
    }

    public function load_file()
    {
        $args = func_get_args();

        if (($doc = call_user_func_array('file_get_contents', $args)) !== false) {
            $this->load($doc, true);
        } else {
            return false;
        }
    }

    public function load(
        $str,
        $lowercase = true,
        $stripRN = false,
        $defaultBRText = DEFAULT_BR_TEXT,
        $defaultSpanText = DEFAULT_SPAN_TEXT,
        $options = 0
    ) {
        // prepare
        $this->prepare($str, $lowercase, $defaultBRText, $defaultSpanText);

        // Per sourceforge http://sourceforge.net/tracker/?func=detail&aid=2949097&group_id=218559&atid=1044037
        // Script tags removal now preceeds style tag removal.
        // strip out <script> tags
        $this->remove_noise("'<\s*script[^>]*[^/]>(.*?)<\s*/\s*script\s*>'is");
        $this->remove_noise("'<\s*script\s*>(.*?)<\s*/\s*script\s*>'is");

        // strip out the \r \n's if we are told to.
        if ($stripRN) {
            $this->doc = str_replace("\r", ' ', $this->doc);
            $this->doc = str_replace("\n", ' ', $this->doc);

            // set the length of content since we have changed it.
            $this->size = strlen($this->doc);
        }

        // strip out cdata
        $this->remove_noise("'<!\[CDATA\[(.*?)\]\]>'is", true);
        // strip out comments
        $this->remove_noise("'<!--(.*?)-->'is");
        // strip out <style> tags
        $this->remove_noise("'<\s*style[^>]*[^/]>(.*?)<\s*/\s*style\s*>'is");
        $this->remove_noise("'<\s*style\s*>(.*?)<\s*/\s*style\s*>'is");
        // strip out preformatted tags
        $this->remove_noise("'<\s*(?:code)[^>]*>(.*?)<\s*/\s*(?:code)\s*>'is");
        // strip out server side scripts
        $this->remove_noise("'(<\?)(.*?)(\?>)'s", true);

        if ($options & HDOM_SMARTY_AS_TEXT) { // Strip Smarty scripts
            $this->remove_noise("'(\{\w)(.*?)(\})'s", true);
        }

        // parsing
        $this->parse();
        // end
        $this->root->_[HDOM_INFO_END] = $this->cursor;
        $this->parse_charset();

        // make load function chainable
        return $this;
    }

    protected function prepare(
        $str,
        $lowercase = true,
        $defaultBRText = DEFAULT_BR_TEXT,
        $defaultSpanText = DEFAULT_SPAN_TEXT
    ) {
        $this->clear();

        $this->doc = trim($str);
        $this->size = strlen($this->doc);
        $this->original_size = $this->size; // original size of the html
        $this->pos = 0;
        $this->cursor = 1;
        $this->noise = array();
        $this->nodes = array();
        $this->lowercase = $lowercase;
        $this->default_br_text = $defaultBRText;
        $this->default_span_text = $defaultSpanText;
        $this->root = new HtmlDomNode($this);
        $this->root->tag = 'root';
        $this->root->_[HDOM_INFO_BEGIN] = -1;
        $this->root->nodetype = HDOM_TYPE_ROOT;
        $this->parent = $this->root;

        if ($this->size > 0) {
            $this->char = $this->doc[0];
        }
    }

    public function clear()
    {
        if (isset($this->nodes)) {
            foreach ($this->nodes as $n) {
                $n->clear();
                $n = null;
            }
        }

        // This add next line is documented in the sourceforge repository.
        // 2977248 as a fix for ongoing memory leaks that occur even with the
        // use of clear.
        if (isset($this->children)) {
            foreach ($this->children as $n) {
                $n->clear();
                $n = null;
            }
        }

        if (isset($this->parent)) {
            $this->parent->clear();
            unset($this->parent);
        }

        if (isset($this->root)) {
            $this->root->clear();
            unset($this->root);
        }

        unset($this->doc);
        unset($this->noise);
    }

    protected function remove_noise($pattern, $remove_tag = false)
    {
        global $debug_object;
        if (is_object($debug_object)) {
            $debug_object->debugLogEntry(1);
        }

        $count = preg_match_all(
            $pattern,
            $this->doc,
            $matches,
            PREG_SET_ORDER | PREG_OFFSET_CAPTURE
        );

        for ($i = $count - 1; $i > -1; --$i) {
            $key = '___noise___' . sprintf('% 5d', count($this->noise) + 1000);

            if (is_object($debug_object)) {
                $debug_object->debug_log(2, 'key is: ' . $key);
            }

            $idx = ($remove_tag) ? 0 : 1; // 0 = entire match, 1 = submatch
            $this->noise[$key] = $matches[$i][$idx][0];
            $this->doc = substr_replace($this->doc, $key, $matches[$i][$idx][1], strlen($matches[$i][$idx][0]));
        }

        // reset the length of content
        $this->size = strlen($this->doc);

        if ($this->size > 0) {
            $this->char = $this->doc[0];
        }
    }

    protected function parse()
    {
        while (true) {
            // Read next tag if there is no text between current position and the
            // next opening tag.
            if (($s = $this->copyUntilChar('<')) === '') {
                if ($this->readTag()) {
                    continue;
                } else {
                    return true;
                }
            }

            // Add a text node for text between tags
            $node = new HtmlDomNode($this);
            ++$this->cursor;
            $node->_[HDOM_INFO_TEXT] = $s;
            $this->linkNodes($node, false);
        }
    }

    protected function copyUntilChar($char)
    {
        if ($this->char === null) {
            return '';
        }

        if (($pos = strpos($this->doc, $char, $this->pos)) === false) {
            $ret = substr($this->doc, $this->pos, $this->size - $this->pos);
            $this->char = null;
            $this->pos = $this->size;
            return $ret;
        }

        if ($pos === $this->pos) {
            return '';
        }

        $pos_old = $this->pos;
        $this->char = $this->doc[$pos];
        $this->pos = $pos;
        return substr($this->doc, $pos_old, $pos - $pos_old);
    }

    protected function readTag()
    {
        // Set end position if no further tags found
        if ($this->char !== '<') {
            $this->root->_[HDOM_INFO_END] = $this->cursor;
            return false;
        }

        $begin_tag_pos = $this->pos;
        $this->char = (++$this->pos < $this->size) ? $this->doc[$this->pos] : null; // next

        // end tag
        if ($this->char === '/') {
            $this->char = (++$this->pos < $this->size) ? $this->doc[$this->pos] : null; // next

            // Skip whitespace in end tags (i.e. in "</   html>")
            $this->skip($this->token_blank);
            $tag = $this->copyUntilChar('>');

            // Skip attributes in end tags
            if (($pos = strpos($tag, ' ')) !== false) {
                $tag = substr($tag, 0, $pos);
            }

            $parent_lower = strtolower($this->parent->tag);
            $tag_lower = strtolower($tag);

            // The end tag is supposed to close the parent tag. Handle situations
            // when it doesn't
            if ($parent_lower !== $tag_lower) {
                // Parent tag does not have to be closed necessarily (optional closing tag)
                // Current tag is a block tag, so it may close an ancestor
                if (isset($this->optional_closing_tags[$parent_lower])
                    && isset($this->block_tags[$tag_lower])) {
                    $this->parent->_[HDOM_INFO_END] = 0;
                    $org_parent = $this->parent;

                    // Traverse ancestors to find a matching opening tag
                    // Stop at root node
                    while (($this->parent->parent)
                        && strtolower($this->parent->tag) !== $tag_lower
                    ) {
                        $this->parent = $this->parent->parent;
                    }

                    // If we don't have a match add current tag as text node
                    if (strtolower($this->parent->tag) !== $tag_lower) {
                        $this->parent = $org_parent; // restore origonal parent

                        if ($this->parent->parent) {
                            $this->parent = $this->parent->parent;
                        }

                        $this->parent->_[HDOM_INFO_END] = $this->cursor;
                        return $this->as_text_node($tag);
                    }
                } elseif (($this->parent->parent)
                    && isset($this->block_tags[$tag_lower])
                ) {
                    // Grandparent exists and current tag is a block tag, so our
                    // parent doesn't have an end tag
                    $this->parent->_[HDOM_INFO_END] = 0; // No end tag
                    $org_parent = $this->parent;

                    // Traverse ancestors to find a matching opening tag
                    // Stop at root node
                    while (($this->parent->parent)
                        && strtolower($this->parent->tag) !== $tag_lower
                    ) {
                        $this->parent = $this->parent->parent;
                    }

                    // If we don't have a match add current tag as text node
                    if (strtolower($this->parent->tag) !== $tag_lower) {
                        $this->parent = $org_parent; // restore origonal parent
                        $this->parent->_[HDOM_INFO_END] = $this->cursor;
                        return $this->as_text_node($tag);
                    }
                } elseif (($this->parent->parent)
                    && strtolower($this->parent->parent->tag) === $tag_lower
                ) { // Grandparent exists and current tag closes it
                    $this->parent->_[HDOM_INFO_END] = 0;
                    $this->parent = $this->parent->parent;
                } else { // Random tag, add as text node
                    return $this->as_text_node($tag);
                }
            }

            // Set end position of parent tag to current cursor position
            $this->parent->_[HDOM_INFO_END] = $this->cursor;

            if ($this->parent->parent) {
                $this->parent = $this->parent->parent;
            }

            $this->char = (++$this->pos < $this->size) ? $this->doc[$this->pos] : null; // next
            return true;
        }

        // start tag
        $node = new HtmlDomNode($this);
        $node->_[HDOM_INFO_BEGIN] = $this->cursor;
        ++$this->cursor;
        $tag = $this->copyUntil($this->token_slash); // Get tag name
        $node->tag_start = $begin_tag_pos;

        // doctype, cdata & comments...
        // <!DOCTYPE html>
        // <![CDATA[ ... ]]>
        // <!-- Comment -->
        if (isset($tag[0]) && $tag[0] === '!') {
            $node->_[HDOM_INFO_TEXT] = '<' . $tag . $this->copyUntilChar('>');

            if (isset($tag[2]) && $tag[1] === '-' && $tag[2] === '-') { // Comment ("<!--")
                $node->nodetype = HDOM_TYPE_COMMENT;
                $node->tag = 'comment';
            } else { // Could be doctype or CDATA but we don't care
                $node->nodetype = HDOM_TYPE_UNKNOWN;
                $node->tag = 'unknown';
            }

            if ($this->char === '>') {
                $node->_[HDOM_INFO_TEXT] .= '>';
            }

            $this->linkNodes($node, true);
            $this->char = (++$this->pos < $this->size) ? $this->doc[$this->pos] : null; // next
            return true;
        }

        // The start tag cannot contain another start tag, if so add as text
        // i.e. "<<html>"
        if ($pos = strpos($tag, '<') !== false) {
            $tag = '<' . substr($tag, 0, -1);
            $node->_[HDOM_INFO_TEXT] = $tag;
            $this->linkNodes($node, false);
            $this->char = $this->doc[--$this->pos]; // prev
            return true;
        }

        // Handle invalid tag names (i.e. "<html#doc>")
        if (!preg_match('/^\w[\w:-]*$/', $tag)) {
            $node->_[HDOM_INFO_TEXT] = '<' . $tag . $this->copyUntil('<>');

            // Next char is the beginning of a new tag, don't touch it.
            if ($this->char === '<') {
                $this->linkNodes($node, false);
                return true;
            }

            // Next char closes current tag, add and be done with it.
            if ($this->char === '>') {
                $node->_[HDOM_INFO_TEXT] .= '>';
            }
            $this->linkNodes($node, false);
            $this->char = (++$this->pos < $this->size) ? $this->doc[$this->pos] : null; // next
            return true;
        }

        // begin tag, add new node
        $node->nodetype = HDOM_TYPE_ELEMENT;
        $tag_lower = strtolower($tag);
        $node->tag = ($this->lowercase) ? $tag_lower : $tag;

        // handle optional closing tags
        if (isset($this->optional_closing_tags[$tag_lower])) {
            // Traverse ancestors to close all optional closing tags
            while (isset($this->optional_closing_tags[$tag_lower][strtolower($this->parent->tag)])) {
                $this->parent->_[HDOM_INFO_END] = 0;
                $this->parent = $this->parent->parent;
            }
            $node->parent = $this->parent;
        }

        $guard = 0; // prevent infinity loop

        // [0] Space between tag and first attribute
        $space = array($this->copySkip($this->token_blank), '', '');

        // attributes
        do {
            // Everything until the first equal sign should be the attribute name
            $name = $this->copyUntil($this->token_equal);

            if ($name === '' && $this->char !== null && $space[0] === '') {
                break;
            }

            if ($guard === $this->pos) { // Escape infinite loop
                $this->char = (++$this->pos < $this->size) ? $this->doc[$this->pos] : null; // next
                continue;
            }

            $guard = $this->pos;

            // handle endless '<'
            // Out of bounds before the tag ended
            if ($this->pos >= $this->size - 1 && $this->char !== '>') {
                $node->nodetype = HDOM_TYPE_TEXT;
                $node->_[HDOM_INFO_END] = 0;
                $node->_[HDOM_INFO_TEXT] = '<' . $tag . $space[0] . $name;
                $node->tag = 'text';
                $this->linkNodes($node, false);
                return true;
            }

            // handle mismatch '<'
            // Attributes cannot start after opening tag
            if ($this->doc[$this->pos - 1] == '<') {
                $node->nodetype = HDOM_TYPE_TEXT;
                $node->tag = 'text';
                $node->attr = array();
                $node->_[HDOM_INFO_END] = 0;
                $node->_[HDOM_INFO_TEXT] = substr(
                    $this->doc,
                    $begin_tag_pos,
                    $this->pos - $begin_tag_pos - 1
                );
                $this->pos -= 2;
                $this->char = (++$this->pos < $this->size) ? $this->doc[$this->pos] : null; // next
                $this->linkNodes($node, false);
                return true;
            }

            if ($name !== '/' && $name !== '') { // this is a attribute name
                // [1] Whitespace after attribute name
                $space[1] = $this->copySkip($this->token_blank);

                $name = $this->restoreNoise($name); // might be a noisy name

                if ($this->lowercase) {
                    $name = strtolower($name);
                }

                if ($this->char === '=') { // attribute with value
                    $this->char = (++$this->pos < $this->size) ? $this->doc[$this->pos] : null; // next
                    $this->parse_attr($node, $name, $space); // get attribute value
                } else {
                    //no value attr: nowrap, checked selected...
                    $node->_[HDOM_INFO_QUOTE][] = HDOM_QUOTE_NO;
                    $node->attr[$name] = true;
                    if ($this->char != '>') {
                        $this->char = $this->doc[--$this->pos];
                    } // prev
                }

                $node->_[HDOM_INFO_SPACE][] = $space;

                // prepare for next attribute
                $space = array(
                    $this->copySkip($this->token_blank),
                    '',
                    ''
                );
            } else { // no more attributes
                break;
            }
        } while ($this->char !== '>' && $this->char !== '/'); // go until the tag ended

        $this->linkNodes($node, true);
        $node->_[HDOM_INFO_ENDSPACE] = $space[0];

        // handle empty tags (i.e. "<div/>")
        if ($this->copyUntilChar('>') === '/') {
            $node->_[HDOM_INFO_ENDSPACE] .= '/';
            $node->_[HDOM_INFO_END] = 0;
        } else {
            // reset parent
            if (!isset($this->self_closing_tags[strtolower($node->tag)])) {
                $this->parent = $node;
            }
        }

        $this->char = (++$this->pos < $this->size) ? $this->doc[$this->pos] : null; // next

        // If it's a BR tag, we need to set it's text to the default text.
        // This way when we see it in plaintext, we can generate formatting that the user wants.
        // since a br tag never has sub nodes, this works well.
        if ($node->tag === 'br') {
            $node->_[HDOM_INFO_INNER] = $this->default_br_text;
        }

        return true;
    }

    protected function skip($chars)
    {
        $this->pos += strspn($this->doc, $chars, $this->pos);
        $this->char = ($this->pos < $this->size) ? $this->doc[$this->pos] : null; // next
    }

    protected function as_text_node($tag)
    {
        $node = new HtmlDomNode($this);
        ++$this->cursor;
        $node->_[HDOM_INFO_TEXT] = '</' . $tag . '>';
        $this->linkNodes($node, false);
        $this->char = (++$this->pos < $this->size) ? $this->doc[$this->pos] : null; // next
        return true;
    }

    protected function linkNodes(&$node, $is_child)
    {
        $node->parent = $this->parent;
        $this->parent->nodes[] = $node;
        if ($is_child) {
            $this->parent->children[] = $node;
        }
    }

    protected function copyUntil($chars)
    {
        $pos = $this->pos;
        $len = strcspn($this->doc, $chars, $pos);
        $this->pos += $len;
        $this->char = ($this->pos < $this->size) ? $this->doc[$this->pos] : null; // next
        return substr($this->doc, $pos, $len);
    }

    protected function copySkip($chars)
    {
        $pos = $this->pos;
        $len = strspn($this->doc, $chars, $pos);
        $this->pos += $len;
        $this->char = ($this->pos < $this->size) ? $this->doc[$this->pos] : null;
        if ($len === 0) {
            return '';
        }

        return substr($this->doc, $pos, $len);
    }

    public function restoreNoise($text)
    {
        global $debug_object;
        if (is_object($debug_object)) {
            $debug_object->debugLogEntry(1);
        }

        while (($pos = strpos($text, '___noise___')) !== false) {
            // Sometimes there is a broken piece of markup, and we don't GET the
            // pos+11 etc... token which indicates a problem outside of us...

            // todo: "___noise___1000" (or any number with four or more digits)
            // in the DOM causes an infinite loop which could be utilized by
            // malicious software
            if (strlen($text) > $pos + 15) {
                $key = '___noise___'
                    . $text[$pos + 11]
                    . $text[$pos + 12]
                    . $text[$pos + 13]
                    . $text[$pos + 14]
                    . $text[$pos + 15];

                if (is_object($debug_object)) {
                    $debug_object->debug_log(2, 'located key of: ' . $key);
                }

                if (isset($this->noise[$key])) {
                    $text = substr($text, 0, $pos)
                        . $this->noise[$key]
                        . substr($text, $pos + 16);
                } else {
                    // do this to prevent an infinite loop.
                    $text = substr($text, 0, $pos)
                        . 'UNDEFINED NOISE FOR KEY: '
                        . $key
                        . substr($text, $pos + 16);
                }
            } else {
                // There is no valid key being given back to us... We must get
                // rid of the ___noise___ or we will have a problem.
                $text = substr($text, 0, $pos)
                    . 'NO NUMERIC NOISE KEY'
                    . substr($text, $pos + 11);
            }
        }
        return $text;
    }

    protected function parse_attr($node, $name, &$space)
    {
        $is_duplicate = isset($node->attr[$name]);

        if (!$is_duplicate) { // Copy whitespace between "=" and value
            $space[2] = $this->copySkip($this->token_blank);
        }

        switch ($this->char) {
            case '"':
                $quote_type = HDOM_QUOTE_DOUBLE;
                $this->char = (++$this->pos < $this->size) ? $this->doc[$this->pos] : null; // next
                $value = $this->copyUntilChar('"');
                $this->char = (++$this->pos < $this->size) ? $this->doc[$this->pos] : null; // next
                break;
            case '\'':
                $quote_type = HDOM_QUOTE_SINGLE;
                $this->char = (++$this->pos < $this->size) ? $this->doc[$this->pos] : null; // next
                $value = $this->copyUntilChar('\'');
                $this->char = (++$this->pos < $this->size) ? $this->doc[$this->pos] : null; // next
                break;
            default:
                $quote_type = HDOM_QUOTE_NO;
                $value = $this->copyUntil($this->token_attr);
        }

        $value = $this->restoreNoise($value);

        // PaperG: Attributes should not have \r or \n in them, that counts as
        // html whitespace.
        $value = str_replace("\r", '', $value);
        $value = str_replace("\n", '', $value);

        // PaperG: If this is a "class" selector, lets get rid of the preceeding
        // and trailing space since some people leave it in the multi class case.
        if ($name === 'class') {
            $value = trim($value);
        }

        if (!$is_duplicate) {
            $node->_[HDOM_INFO_QUOTE][] = $quote_type;
            $node->attr[$name] = $value;
        }
    }

    protected function parse_charset()
    {
        global $debug_object;

        $charset = null;

        if (function_exists('get_last_retrieve_url_contents_content_type')) {
            $contentTypeHeader = get_last_retrieve_url_contents_content_type();
            $success = preg_match('/charset=(.+)/', $contentTypeHeader, $matches);
            if ($success) {
                $charset = $matches[1];
                if (is_object($debug_object)) {
                    $debug_object->debug_log(
                        2,
                        'header content-type found charset of: '
                        . $charset
                    );
                }
            }
        }

        if (empty($charset)) {
            // https://www.w3.org/TR/html/document-metadata.html#statedef-http-equiv-content-type
            $el = $this->root->find('meta[http-equiv=Content-Type]', 0, true);

            if (!empty($el)) {
                $fullvalue = $el->content;
                if (is_object($debug_object)) {
                    $debug_object->debug_log(
                        2,
                        'meta content-type tag found'
                        . $fullvalue
                    );
                }

                if (!empty($fullvalue)) {
                    $success = preg_match(
                        '/charset=(.+)/i',
                        $fullvalue,
                        $matches
                    );

                    if ($success) {
                        $charset = $matches[1];
                    } else {
                        // If there is a meta tag, and they don't specify the
                        // character set, research says that it's typically
                        // ISO-8859-1
                        if (is_object($debug_object)) {
                            $debug_object->debug_log(
                                2,
                                'meta content-type tag couldn\'t be parsed. using iso-8859 default.'
                            );
                        }

                        $charset = 'ISO-8859-1';
                    }
                }
            }
        }

        if (empty($charset)) {
            // https://www.w3.org/TR/html/document-metadata.html#character-encoding-declaration
            if ($meta = $this->root->find('meta[charset]', 0)) {
                $charset = $meta->charset;
                if (is_object($debug_object)) {
                    $debug_object->debug_log(2, 'meta charset: ' . $charset);
                }
            }
        }

        if (empty($charset)) {
            // Try to guess the charset based on the content
            // Requires Multibyte String (mbstring) support (optional)
            if (function_exists('mb_detect_encoding')) {
                /**
                 * mb_detect_encoding() is not intended to distinguish between
                 * charsets, especially single-byte charsets. Its primary
                 * purpose is to detect which multibyte encoding is in use,
                 * i.e. UTF-8, UTF-16, shift-JIS, etc.
                 *
                 * -- https://bugs.php.net/bug.php?id=38138
                 *
                 * Adding both CP1251/ISO-8859-5 and CP1252/ISO-8859-1 will
                 * always result in CP1251/ISO-8859-5 and vice versa.
                 *
                 * Thus, only detect if it's either UTF-8 or CP1252/ISO-8859-1
                 * to stay compatible.
                 */
                $encoding = mb_detect_encoding(
                    $this->doc,
                    array( 'UTF-8', 'CP1252', 'ISO-8859-1' )
                );

                if ($encoding === 'CP1252' || $encoding === 'ISO-8859-1') {
                    // Due to a limitation of mb_detect_encoding
                    // 'CP1251'/'ISO-8859-5' will be detected as
                    // 'CP1252'/'ISO-8859-1'. This will cause iconv to fail, in
                    // which case we can simply assume it is the other charset.
                    if (!@iconv('CP1252', 'UTF-8', $this->doc)) {
                        $encoding = 'CP1251';
                    }
                }

                if ($encoding !== false) {
                    $charset = $encoding;
                    if (is_object($debug_object)) {
                        $debug_object->debug_log(2, 'mb_detect: ' . $charset);
                    }
                }
            }
        }

        if (empty($charset)) {
            // Assume it's UTF-8 as it is the most likely charset to be used
            $charset = 'UTF-8';
            if (is_object($debug_object)) {
                $debug_object->debug_log(2, 'No match found, assume ' . $charset);
            }
        }

        // Since CP1252 is a superset, if we get one of it's subsets, we want
        // it instead.
        if ((strtolower($charset) == 'iso-8859-1')
            || (strtolower($charset) == 'latin1')
            || (strtolower($charset) == 'latin-1')) {
            $charset = 'CP1252';
            if (is_object($debug_object)) {
                $debug_object->debug_log(
                    2,
                    'replacing ' . $charset . ' with CP1252 as its a superset'
                );
            }
        }

        if (is_object($debug_object)) {
            $debug_object->debug_log(1, 'EXIT - ' . $charset);
        }

        return $this->_charset = $charset;
    }

    public function __destruct()
    {
        $this->clear();
    }

    public function set_callback($function_name)
    {
        $this->callback = $function_name;
    }

    public function remove_callback()
    {
        $this->callback = null;
    }

    public function save($filepath = '')
    {
        $ret = $this->root->innertext();
        if ($filepath !== '') {
            file_put_contents($filepath, $ret, LOCK_EX);
        }

        return $ret;
    }

    public function dump($show_attr = true)
    {
        $this->root->dump($show_attr);
    }

    public function searchNoise($text)
    {
        global $debug_object;

        if (is_object($debug_object)) {
            $debug_object->debugLogEntry(1);
        }

        foreach ($this->noise as $noiseElement) {
            if (strpos($noiseElement, $text) !== false) {
                return $noiseElement;
            }
        }
    }

    public function __toString()
    {
        return $this->root->innertext();
    }

    public function __get($name)
    {
        switch ($name) {
            case 'outertext':
                return $this->root->outertext();
            case 'innertext':
                return $this->root->innertext();
            case 'plaintext':
                return $this->root->text();
            case 'charset':
                return $this->_charset;
            case 'target_charset':
                return $this->_target_charset;
        }
    }

    public function childNodes($idx = -1)
    {
        return $this->root->childNodes($idx);
    }

    public function lastChild()
    {
        return $this->root->last_child();
    }

    public function createElement($name, $value = null)
    {
        return @str_get_html("<$name>$value</$name>")->firstChild();
    }

    public function firstChild()
    {
        return $this->root->first_child();
    }

    public function createTextNode($value)
    {
        return @end(str_get_html($value)->nodes);
    }

    public function getElementById($id)
    {
        return $this->find("#$id", 0);
    }

    public function find($selector, $idx = null, $lowercase = false)
    {
        return $this->root->find($selector, $idx, $lowercase);
    }

    public function getElementsById($id, $idx = null)
    {
        return $this->find("#$id", $idx);
    }

    public function getElementByTagName($name)
    {
        return $this->find($name, 0);
    }

    public function getElementsByTagName($name, $idx = -1)
    {
        return $this->find($name, $idx);
    }

    public function loadFile()
    {
        $args = func_get_args();
        $this->load_file($args);
    }
}
