<?php

if (class_exists('PEAR_Sniffs_Commenting_FunctionCommentSniff', true) === false) {
    $error = 'Class PEAR_Sniffs_Commenting_FunctionCommentSniff not found';
    throw new PHP_CodeSniffer_Exception($error);
}

/**
 * Symfony2 standard customization to PEARs FunctionCommentSniff.
 *
 * Verifies that :
 * <ul>
 *  <li>There is a @return tag iff a return statement exists inside the method</li>
 * </ul>
 *
 * @package   PHP_CodeSniffer
 * @author    Felix Brandt <mail@felixbrandt.de>
 * @license   http://matrix.squiz.net/developer/tools/php_cs/licence BSD Licence
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */
class Symfony2_Sniffs_Commenting_FunctionCommentSniff extends PEAR_Sniffs_Commenting_FunctionCommentSniff
{

    /**
     * Process the return comment of this function comment.
     *
     * @param int $commentStart The position in the stack where the comment started.
     * @param int $commentEnd   The position in the stack where the comment ended.
     *
     * @return void
     */
    protected function processReturn($commentStart, $commentEnd)
    {
        $tokens = $this->currentFile->getTokens();
        $funcPtr = $this->currentFile->findNext(T_FUNCTION, $commentEnd);

        // Only check for a return comment if a non-void return statement exists
        if (isset($tokens[$funcPtr]['scope_opener'])) {
            $start = $tokens[$funcPtr]['scope_opener'];

            // iterate over all return statements of this function,
            // run the check on the first which is not only 'return;'
            while ($returnToken = $this->currentFile->findNext(T_RETURN, $start, $tokens[$funcPtr]['scope_closer'])) {
                if ($this->isMatchingReturn($tokens, $returnToken)) {
                    parent::processReturn($commentStart, $commentEnd);
                    break;
                }
                $start = $returnToken + 1;
            }
        }

    } /* end processReturn() */

    /**
     * Is the return statement matching?
     *
     * @param array $tokens    Array of tokens
     * @param int   $returnPos Stack position of the T_RETURN token to process
     *
     * @return boolean True if the return does not return anything
     */
    protected function isMatchingReturn ($tokens, $returnPos)
    {
      do {
        $returnPos++;
      } while ($tokens[$returnPos]['code'] === T_WHITESPACE);

      return $tokens[$returnPos]['code'] !== T_SEMICOLON;
    }

}//end class

?>
