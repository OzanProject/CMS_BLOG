<?php
$content = file_get_contents($argv[1]);
$tokens = token_get_all("<?php " . $content); // Not perfect for Blade but let's try regex

$openIf = preg_match_all('/@if\b/', $content);
$closeIf = preg_match_all('/@endif\b/', $content);
$elseIf = preg_match_all('/@elseif\b/', $content);
$else = preg_match_all('/@else\b/', $content);

$openForeach = preg_match_all('/@foreach\b/', $content);
$closeForeach = preg_match_all('/@endforeach\b/', $content);

$openForelse = preg_match_all('/@forelse\b/', $content);
$empty = preg_match_all('/@empty\b/', $content);
$closeForelse = preg_match_all('/@endforelse\b/', $content);

$openSection = preg_match_all('/@section\b/', $content);
$closeSection = preg_match_all('/@endsection\b/', $content);

$openPush = preg_match_all('/@push\b/', $content);
$closePush = preg_match_all('/@endpush\b/', $content);

$openPhp = preg_match_all('/@php\b/', $content);
$closePhp = preg_match_all('/@endphp\b/', $content);

echo "IF: $openIf | ENDIF: $closeIf\n";
echo "FOREACH: $openForeach | ENDFOREACH: $closeForeach\n";
echo "FORELSE: $openForelse | EMPTY: $empty | ENDFORELSE: $closeForelse\n";
echo "SECTION: $openSection | ENDSECTION: $closeSection\n";
echo "PUSH: $openPush | ENDPUSH: $closePush\n";
echo "PHP: $openPhp | ENDPHP: $closePhp\n";

// Find mismatched IF
$stack = [];
$lines = explode("\n", $content);
foreach($lines as $i => $line) {
    if (preg_match('/@if\b/', $line)) $stack[] = "IF at " . ($i+1);
    if (preg_match('/@endif\b/', $line)) array_pop($stack);
}
echo "Unclosed: " . implode(", ", $stack) . "\n";
