<?php
/**
 * Created by PhpStorm.
 * User: vlad
 * Date: 15-07-20
 * Time: 4:50 PM
 */
if (!function_exists('mapTrans'))
{
    /**
     * @param       $string
     * @param       $prefix
     * @param array $params
     *
     * @return mixed
     */
    function mapTrans($string, $prefix, array $params = [])
    {
        $namespace = $prefix . '.' . $string;
        $trans = trans($namespace, $params);
        if ($trans === $namespace) $trans = $string;
        return $trans;
    }
}

if (!function_exists('transLang'))
{
    /**
     * @param       $string
     * @param       $prefix
     * @param array $params
     *
     * @return mixed
     */
    function transLang($key, array $replace = array(), $locale = null, $useDB = null)
    {
        $trans = App::make('translator');
        return $trans->get($key, $replace, $locale, $useDB);
    }
}

if (!function_exists('noEditTransEmptyUndefined'))
{
    /**
     * @param       $string
     * @param       $prefix
     * @param array $params
     *
     * @return mixed
     */
    function noEditTransEmptyUndefined($key, array $replace = array(), $locale = null, $useDB = null)
    {
        $trans = App::make('translator');
        if ($trans->inPlaceEditing())
        {
            /* @var $trans Translator */
            $trans->suspendInPlaceEditing();
            $text = $trans->get($key, $replace, $locale, $useDB);
            $trans->resumeInPlaceEditing();
        }
        else
        {
            $text = $trans->get($key, $replace, $locale, $useDB);
        }
        return $text === $key ? '' : $text;
    }
}

if (!function_exists('transChoice'))
{
    /**
     * @param       $string
     * @param       $prefix
     * @param array $params
     *
     * @return mixed
     */
    function transChoice($key, $number, array $replace = array(), $locale = null, $useDB = null)
    {
        $trans = App::make('translator');
        return $trans->choice($key, $number, $replace, $locale, $useDB);
    }
}

if (!function_exists('noEditTrans'))
{
    /**
     * @param       $key
     * @param array $parameters
     * @param null  $locale
     * @param null  $useDB
     *
     * @return mixed
     *
     */
    function noEditTrans($key, $parameters = array(), $locale = null, $useDB = null)
    {
        $trans = App::make('translator');
        if ($trans->inPlaceEditing())
        {
            /* @var $trans Translator */
            $trans->suspendInPlaceEditing();
            $text = $trans->get($key, $parameters, $locale, $useDB);
            $trans->resumeInPlaceEditing();
            return $text;
        }
        return $trans->get($key, $parameters, $locale, $useDB);
    }
}

if (!function_exists('ifEditTrans'))
{
    /**
     * @param       $key
     * @param array $parameters
     * @param null  $locale
     * @param null  $useDB
     *
     * @return mixed
     *
     */
    function ifEditTrans($key, $parameters = array(), $locale = null, $useDB = null, $noWrap = null)
    {
        $trans = App::make('translator');
        if ($trans->inPlaceEditing())
        {
            /* @var $trans Translator */
            $text = $trans->getInPlaceEditLink($key, $parameters, $locale, $useDB);
            return $noWrap ? $text : "<br>[$text]";
        }
        return '';
    }
}

if (!function_exists('ifInPlaceEdit'))
{
    /**
     * @param       $string
     * @param       $prefix
     * @param array $params
     *
     * @return mixed
     */
    function ifInPlaceEdit($text, $replace = [], $locale = null, $useDB = null, $noWrap = null)
    {
        /* @var $trans Translator */
        $trans = App::make('translator');
        if ($trans->inPlaceEditing())
        {
            while (preg_match('/@lang\(\'([^\']+)\'\)/', $text, $matches))
            {

                $repl = $trans->getInPlaceEditLink($matches[1], $replace, $locale, $useDB);
                $text = str_replace($matches[0], $repl, $text);
            }
            return $noWrap ? $text : "<br>[$text]";
        }
        return '';
    }
}

if (!function_exists('inPlaceEditing'))
{
    /**
     * @return string
     *
     */
    function inPlaceEditing($inPlaceEditing = null)
    {
        $trans = App::make('translator');
        return $trans->inPlaceEditing($inPlaceEditing);
    }
}

if (!function_exists('formSubmit'))
{
    function formSubmit($value = null, $options = array())
    {
        if (inPlaceEditing())
        {
            $innerText = preg_match('/^\s*<a\s*[^>]*>([^<]*)<\/a>\s*$/', $value, $matches) ? $matches[1] : $value;
            if ($innerText !== $value)
            {
                return Form::submit($innerText, $options) . "[$value]";
            }
        }
        return Form::submit($value, $options);
    }
}

if (!function_exists('mb_replace'))
{
    function mb_replace($search, $replace, $subject, &$count = null)
    {
        if (!is_array($search)) $search = array($search);
        if (!is_array($replace)) $replace = array($replace);
        $sMax = count($search);
        $rMax = count($replace);

        $result = '';
        $count = 0;
        $len = mb_strlen($subject);

        for ($s = 0; $s < $sMax; $s++)
        {
            $find = $search[$s];
            $pos = 0;

            while ($pos < $len)
            {
                $lastPos = $pos;
                if (($pos = mb_strpos($subject, $find, $pos)) === false)
                {
                    $result .= mb_substr($subject, $lastPos);
                    break;
                }

                $result .= mb_substr($subject, $lastPos, $pos - $lastPos);
                if ($s < $rMax) $result .= $replace[$s];
                $pos += mb_strlen($find);
                $count++;
            }
        }

        return $result;
    }
}

if (!function_exists('mb_chunk_split'))
{
    function mb_chunk_split($body, $chunklen = 76, $end = "\r\n")
    {
        $split = '';
        $pos = 0;
        $len = mb_strlen($body);
        while ($pos < $len)
        {
            $split .= mb_substr($body, $pos, $chunklen) . $end;
            $pos += $chunklen;
        }
        return $split;
    }
}

if (!function_exists('mb_unsplit'))
{
    function mb_unsplit($body, $end = "\r\n")
    {
        $split = '';
        $pos = 0;
        $len = mb_strlen($body);
        $skip = mb_strlen($end);
        while ($pos < $len)
        {
            $next = strpos($body, $end, $pos);
            if ($next === false)
            {
                $split .= mb_substr($body, $pos);
                break;
            }

            $split .= mb_substr($body, $pos, $next - $pos);
            $pos = $next + $skip;
            if (mb_substr($body, $pos, $skip) === $end)
            {
                // keep the second
                $split .= mb_substr($body, $pos, $skip);
                $pos += $skip;
            }
        }
        return $split;
    }
}

if (!function_exists('mb_renderDiffHtml'))
{

    /**
     * @param      $from_text
     * @param      $to_text
     *
     * @param bool $charDiff
     *
     * @return array
     */
    function mb_renderDiffHtml($from_text, $to_text, $charDiff = null)
    {
        //if ($from_text === 'Lang' && $to_text === 'Language') xdebug_break();
        if ($from_text == $to_text) return $to_text;

        $removeSpaces = false;
        if ($charDiff === null)
        {
            $charDiff = mb_strtolower($from_text) === mb_strtolower($to_text)
                || abs(mb_strlen($from_text) - mb_strlen($to_text)) <= 2
                || ($from_text && $to_text
                    && ((strpos($from_text, $to_text) !== false)
                        || ($to_text && strpos($to_text, $from_text) !== false)));
        }

        if ($charDiff)
        {
            //use word diff but space all entities so that we get char diff
            $removeSpaces = true;
            $from_text = mb_chunk_split($from_text, 1, ' ');
            $to_text = mb_chunk_split($to_text, 1, ' ');
        }
        $from_text = mb_convert_encoding($from_text, 'HTML-ENTITIES', 'UTF-8');
        $to_text = mb_convert_encoding($to_text, 'HTML-ENTITIES', 'UTF-8');
        $opcodes = \FineDiff::getDiffOpcodes($from_text, $to_text, \FineDiff::$wordGranularity);
        $diff = \FineDiff::renderDiffToHTMLFromOpcodes($from_text, $opcodes);
        $diff = mb_convert_encoding($diff, 'UTF-8', 'HTML-ENTITIES');
        if ($removeSpaces)
        {
            $diff = mb_unsplit($diff, ' ');
        }
        return $diff;
    }
}
