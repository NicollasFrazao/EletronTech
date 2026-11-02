<?php

declare(strict_types=1);

namespace EletronTech\Sniffs\Commenting;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Every class, interface, trait, enum and public method has a doc comment that starts with a summary.
 *
 * Constructors are exempt: their parameters are documented with `@param` when the type is not
 * enough, and a summary sentence there would only repeat the class's. `{@inheritDoc}` counts as a
 * summary, for implementations of an interface method.
 */
final class RequirePublicDocCommentSniff implements Sniff
{
    /**
     * Tokens that may stand between a declaration and its doc comment.
     */
    private const array SKIPPED_BEFORE_DECLARATION = [
        T_WHITESPACE,
        T_FINAL,
        T_ABSTRACT,
        T_READONLY,
        T_PUBLIC,
        T_PROTECTED,
        T_PRIVATE,
        T_STATIC,
    ];

    /**
     * Declarations this sniff checks.
     *
     * @return list<int|string>
     */
    public function register(): array
    {
        return [T_CLASS, T_INTERFACE, T_TRAIT, T_ENUM, T_FUNCTION];
    }

    /**
     * Reports a declaration without a doc comment, or with one that has no summary.
     *
     * @param  int  $stackPtr  Position of the declaration keyword.
     */
    public function process(File $phpcsFile, $stackPtr): void
    {
        $tokens = $phpcsFile->getTokens();

        if ($tokens[$stackPtr]['code'] === T_FUNCTION && ! $this->isPublicApi($phpcsFile, $stackPtr)) {
            return;
        }

        $closer = $this->docCommentCloser($phpcsFile, $stackPtr);
        $name = $phpcsFile->getDeclarationName($stackPtr);

        if ($closer === null) {
            $phpcsFile->addError('%s has no doc comment; start it with a summary sentence.', $stackPtr, 'Missing', [$name]);

            return;
        }

        if (! $this->hasSummary($phpcsFile, $closer)) {
            $phpcsFile->addError('The doc comment of %s must start with a summary sentence.', $closer, 'MissingSummary', [$name]);
        }
    }

    private function isPublicApi(File $phpcsFile, int $stackPtr): bool
    {
        if ($phpcsFile->getDeclarationName($stackPtr) === '__construct') {
            return false;
        }

        $tokens = $phpcsFile->getTokens();

        if ($tokens[$stackPtr]['conditions'] === []) {
            return true;
        }

        return $phpcsFile->getMethodProperties($stackPtr)['scope'] === 'public';
    }

    private function docCommentCloser(File $phpcsFile, int $stackPtr): ?int
    {
        $tokens = $phpcsFile->getTokens();
        $previous = $stackPtr - 1;

        while ($previous >= 0) {
            $code = $tokens[$previous]['code'];

            if ($code === T_ATTRIBUTE_END) {
                $previous = $tokens[$previous]['attribute_opener'] - 1;

                continue;
            }

            if (! in_array($code, self::SKIPPED_BEFORE_DECLARATION, true)) {
                break;
            }

            $previous--;
        }

        return $previous >= 0 && $tokens[$previous]['code'] === T_DOC_COMMENT_CLOSE_TAG ? $previous : null;
    }

    private function hasSummary(File $phpcsFile, int $closer): bool
    {
        $tokens = $phpcsFile->getTokens();
        $opener = $tokens[$closer]['comment_opener'];
        $first = $phpcsFile->findNext([T_DOC_COMMENT_STRING, T_DOC_COMMENT_TAG], $opener + 1, $closer);

        if ($first === false) {
            return false;
        }

        // Text before the first tag is the summary; an `{@inheritDoc}` line is text too.
        if ($tokens[$first]['code'] === T_DOC_COMMENT_STRING) {
            return true;
        }

        return strcasecmp($tokens[$first]['content'], '@inheritDoc') === 0;
    }
}
