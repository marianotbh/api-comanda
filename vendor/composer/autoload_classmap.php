<?php

// autoload_classmap.php @generated by Composer

$vendorDir = dirname(dirname(__FILE__));
$baseDir = dirname($vendorDir);

return array(
    'App\\Controllers\\AuthController' => $baseDir . '/App/Controllers/AuthController.php',
    'App\\Controllers\\MenuController' => $baseDir . '/App/Controllers/MenuController.php',
    'App\\Controllers\\OrderController' => $baseDir . '/App/Controllers/OrderController.php',
    'App\\Controllers\\OrderDetailController' => $baseDir . '/App/Controllers/OrderDetailController.php',
    'App\\Controllers\\ReviewController' => $baseDir . '/App/Controllers/ReviewController.php',
    'App\\Controllers\\TableController' => $baseDir . '/App/Controllers/TableController.php',
    'App\\Controllers\\UserController' => $baseDir . '/App/Controllers/UserController.php',
    'App\\Core\\Data\\DataAccess' => $baseDir . '/App/Core/Data/DataAccess.php',
    'App\\Core\\Data\\Model' => $baseDir . '/App/Core/Data/Model.php',
    'App\\Core\\Data\\QueryBuilder' => $baseDir . '/App/Core/Data/QueryBuilder.php',
    'App\\Core\\Exceptions\\AppException' => $baseDir . '/App/Core/Exceptions/AppException.php',
    'App\\Core\\Exceptions\\ModelException' => $baseDir . '/App/Core/Exceptions/ModelException.php',
    'App\\Core\\Exceptions\\ValidatorException' => $baseDir . '/App/Core/Exceptions/ValidatorException.php',
    'App\\Core\\Utils\\HashHelper' => $baseDir . '/App/Core/Utils/HashHelper.php',
    'App\\Core\\Utils\\ImageHelper' => $baseDir . '/App/Core/Utils/ImageHelper.php',
    'App\\Core\\Utils\\JWTHelper' => $baseDir . '/App/Core/Utils/JWTHelper.php',
    'App\\Core\\Validation\\Validator' => $baseDir . '/App/Core/Validation/Validator.php',
    'App\\Middleware\\AuthMiddleware' => $baseDir . '/App/Middleware/AuthMiddleware.php',
    'App\\Middleware\\CorsMiddleware' => $baseDir . '/App/Middleware/CorsMiddleware.php',
    'App\\Middleware\\ErrorHandlerMiddleware' => $baseDir . '/App/Middleware/ErrorHandlerMiddleware.php',
    'App\\Middleware\\PayloadMiddleware' => $baseDir . '/App/Middleware/PayloadMiddleware.php',
    'App\\Middleware\\RoleMiddleware' => $baseDir . '/App/Middleware/RoleMiddleware.php',
    'App\\Models\\Log' => $baseDir . '/App/Models/Log.php',
    'App\\Models\\Menu' => $baseDir . '/App/Models/Menu.php',
    'App\\Models\\Order' => $baseDir . '/App/Models/Order.php',
    'App\\Models\\OrderDetail' => $baseDir . '/App/Models/OrderDetail.php',
    'App\\Models\\OrderState' => $baseDir . '/App/Models/OrderState.php',
    'App\\Models\\Review' => $baseDir . '/App/Models/Review.php',
    'App\\Models\\Role' => $baseDir . '/App/Models/Role.php',
    'App\\Models\\Table' => $baseDir . '/App/Models/Table.php',
    'App\\Models\\TableState' => $baseDir . '/App/Models/TableState.php',
    'App\\Models\\User' => $baseDir . '/App/Models/User.php',
    'App\\Services\\AuthService' => $baseDir . '/App/Services/AuthService.php',
    'App\\Services\\MenuService' => $baseDir . '/App/Services/MenuService.php',
    'App\\Services\\OrderDetailService' => $baseDir . '/App/Services/OrderDetailService.php',
    'App\\Services\\OrderService' => $baseDir . '/App/Services/OrderService.php',
    'App\\Services\\ReviewService' => $baseDir . '/App/Services/ReviewService.php',
    'App\\Services\\TableService' => $baseDir . '/App/Services/TableService.php',
    'App\\Services\\UserService' => $baseDir . '/App/Services/UserService.php',
    'Doctrine\\Common\\Lexer\\AbstractLexer' => $vendorDir . '/doctrine/lexer/lib/Doctrine/Common/Lexer/AbstractLexer.php',
    'Dotenv\\Dotenv' => $vendorDir . '/vlucas/phpdotenv/src/Dotenv.php',
    'Dotenv\\Exception\\ExceptionInterface' => $vendorDir . '/vlucas/phpdotenv/src/Exception/ExceptionInterface.php',
    'Dotenv\\Exception\\InvalidFileException' => $vendorDir . '/vlucas/phpdotenv/src/Exception/InvalidFileException.php',
    'Dotenv\\Exception\\InvalidPathException' => $vendorDir . '/vlucas/phpdotenv/src/Exception/InvalidPathException.php',
    'Dotenv\\Exception\\ValidationException' => $vendorDir . '/vlucas/phpdotenv/src/Exception/ValidationException.php',
    'Dotenv\\Loader\\Lines' => $vendorDir . '/vlucas/phpdotenv/src/Loader/Lines.php',
    'Dotenv\\Loader\\Loader' => $vendorDir . '/vlucas/phpdotenv/src/Loader/Loader.php',
    'Dotenv\\Loader\\LoaderInterface' => $vendorDir . '/vlucas/phpdotenv/src/Loader/LoaderInterface.php',
    'Dotenv\\Loader\\Parser' => $vendorDir . '/vlucas/phpdotenv/src/Loader/Parser.php',
    'Dotenv\\Loader\\Value' => $vendorDir . '/vlucas/phpdotenv/src/Loader/Value.php',
    'Dotenv\\Regex\\Regex' => $vendorDir . '/vlucas/phpdotenv/src/Regex/Regex.php',
    'Dotenv\\Repository\\AbstractRepository' => $vendorDir . '/vlucas/phpdotenv/src/Repository/AbstractRepository.php',
    'Dotenv\\Repository\\AdapterRepository' => $vendorDir . '/vlucas/phpdotenv/src/Repository/AdapterRepository.php',
    'Dotenv\\Repository\\Adapter\\ApacheAdapter' => $vendorDir . '/vlucas/phpdotenv/src/Repository/Adapter/ApacheAdapter.php',
    'Dotenv\\Repository\\Adapter\\ArrayAdapter' => $vendorDir . '/vlucas/phpdotenv/src/Repository/Adapter/ArrayAdapter.php',
    'Dotenv\\Repository\\Adapter\\AvailabilityInterface' => $vendorDir . '/vlucas/phpdotenv/src/Repository/Adapter/AvailabilityInterface.php',
    'Dotenv\\Repository\\Adapter\\EnvConstAdapter' => $vendorDir . '/vlucas/phpdotenv/src/Repository/Adapter/EnvConstAdapter.php',
    'Dotenv\\Repository\\Adapter\\PutenvAdapter' => $vendorDir . '/vlucas/phpdotenv/src/Repository/Adapter/PutenvAdapter.php',
    'Dotenv\\Repository\\Adapter\\ReaderInterface' => $vendorDir . '/vlucas/phpdotenv/src/Repository/Adapter/ReaderInterface.php',
    'Dotenv\\Repository\\Adapter\\ServerConstAdapter' => $vendorDir . '/vlucas/phpdotenv/src/Repository/Adapter/ServerConstAdapter.php',
    'Dotenv\\Repository\\Adapter\\WriterInterface' => $vendorDir . '/vlucas/phpdotenv/src/Repository/Adapter/WriterInterface.php',
    'Dotenv\\Repository\\RepositoryBuilder' => $vendorDir . '/vlucas/phpdotenv/src/Repository/RepositoryBuilder.php',
    'Dotenv\\Repository\\RepositoryInterface' => $vendorDir . '/vlucas/phpdotenv/src/Repository/RepositoryInterface.php',
    'Dotenv\\Result\\Error' => $vendorDir . '/vlucas/phpdotenv/src/Result/Error.php',
    'Dotenv\\Result\\Result' => $vendorDir . '/vlucas/phpdotenv/src/Result/Result.php',
    'Dotenv\\Result\\Success' => $vendorDir . '/vlucas/phpdotenv/src/Result/Success.php',
    'Dotenv\\Store\\FileStore' => $vendorDir . '/vlucas/phpdotenv/src/Store/FileStore.php',
    'Dotenv\\Store\\File\\Paths' => $vendorDir . '/vlucas/phpdotenv/src/Store/File/Paths.php',
    'Dotenv\\Store\\File\\Reader' => $vendorDir . '/vlucas/phpdotenv/src/Store/File/Reader.php',
    'Dotenv\\Store\\StoreBuilder' => $vendorDir . '/vlucas/phpdotenv/src/Store/StoreBuilder.php',
    'Dotenv\\Store\\StoreInterface' => $vendorDir . '/vlucas/phpdotenv/src/Store/StoreInterface.php',
    'Dotenv\\Validator' => $vendorDir . '/vlucas/phpdotenv/src/Validator.php',
    'Egulias\\EmailValidator\\EmailLexer' => $vendorDir . '/egulias/email-validator/EmailValidator/EmailLexer.php',
    'Egulias\\EmailValidator\\EmailParser' => $vendorDir . '/egulias/email-validator/EmailValidator/EmailParser.php',
    'Egulias\\EmailValidator\\EmailValidator' => $vendorDir . '/egulias/email-validator/EmailValidator/EmailValidator.php',
    'Egulias\\EmailValidator\\Exception\\AtextAfterCFWS' => $vendorDir . '/egulias/email-validator/EmailValidator/Exception/AtextAfterCFWS.php',
    'Egulias\\EmailValidator\\Exception\\CRLFAtTheEnd' => $vendorDir . '/egulias/email-validator/EmailValidator/Exception/CRLFAtTheEnd.php',
    'Egulias\\EmailValidator\\Exception\\CRLFX2' => $vendorDir . '/egulias/email-validator/EmailValidator/Exception/CRLFX2.php',
    'Egulias\\EmailValidator\\Exception\\CRNoLF' => $vendorDir . '/egulias/email-validator/EmailValidator/Exception/CRNoLF.php',
    'Egulias\\EmailValidator\\Exception\\CharNotAllowed' => $vendorDir . '/egulias/email-validator/EmailValidator/Exception/CharNotAllowed.php',
    'Egulias\\EmailValidator\\Exception\\CommaInDomain' => $vendorDir . '/egulias/email-validator/EmailValidator/Exception/CommaInDomain.php',
    'Egulias\\EmailValidator\\Exception\\ConsecutiveAt' => $vendorDir . '/egulias/email-validator/EmailValidator/Exception/ConsecutiveAt.php',
    'Egulias\\EmailValidator\\Exception\\ConsecutiveDot' => $vendorDir . '/egulias/email-validator/EmailValidator/Exception/ConsecutiveDot.php',
    'Egulias\\EmailValidator\\Exception\\DomainHyphened' => $vendorDir . '/egulias/email-validator/EmailValidator/Exception/DomainHyphened.php',
    'Egulias\\EmailValidator\\Exception\\DotAtEnd' => $vendorDir . '/egulias/email-validator/EmailValidator/Exception/DotAtEnd.php',
    'Egulias\\EmailValidator\\Exception\\DotAtStart' => $vendorDir . '/egulias/email-validator/EmailValidator/Exception/DotAtStart.php',
    'Egulias\\EmailValidator\\Exception\\ExpectingAT' => $vendorDir . '/egulias/email-validator/EmailValidator/Exception/ExpectingAT.php',
    'Egulias\\EmailValidator\\Exception\\ExpectingATEXT' => $vendorDir . '/egulias/email-validator/EmailValidator/Exception/ExpectingATEXT.php',
    'Egulias\\EmailValidator\\Exception\\ExpectingCTEXT' => $vendorDir . '/egulias/email-validator/EmailValidator/Exception/ExpectingCTEXT.php',
    'Egulias\\EmailValidator\\Exception\\ExpectingDTEXT' => $vendorDir . '/egulias/email-validator/EmailValidator/Exception/ExpectingDTEXT.php',
    'Egulias\\EmailValidator\\Exception\\ExpectingDomainLiteralClose' => $vendorDir . '/egulias/email-validator/EmailValidator/Exception/ExpectingDomainLiteralClose.php',
    'Egulias\\EmailValidator\\Exception\\ExpectingQPair' => $vendorDir . '/egulias/email-validator/EmailValidator/Exception/ExpectingQPair.php',
    'Egulias\\EmailValidator\\Exception\\InvalidEmail' => $vendorDir . '/egulias/email-validator/EmailValidator/Exception/InvalidEmail.php',
    'Egulias\\EmailValidator\\Exception\\NoDNSRecord' => $vendorDir . '/egulias/email-validator/EmailValidator/Exception/NoDNSRecord.php',
    'Egulias\\EmailValidator\\Exception\\NoDomainPart' => $vendorDir . '/egulias/email-validator/EmailValidator/Exception/NoDomainPart.php',
    'Egulias\\EmailValidator\\Exception\\NoLocalPart' => $vendorDir . '/egulias/email-validator/EmailValidator/Exception/NoLocalPart.php',
    'Egulias\\EmailValidator\\Exception\\UnclosedComment' => $vendorDir . '/egulias/email-validator/EmailValidator/Exception/UnclosedComment.php',
    'Egulias\\EmailValidator\\Exception\\UnclosedQuotedString' => $vendorDir . '/egulias/email-validator/EmailValidator/Exception/UnclosedQuotedString.php',
    'Egulias\\EmailValidator\\Exception\\UnopenedComment' => $vendorDir . '/egulias/email-validator/EmailValidator/Exception/UnopenedComment.php',
    'Egulias\\EmailValidator\\Parser\\DomainPart' => $vendorDir . '/egulias/email-validator/EmailValidator/Parser/DomainPart.php',
    'Egulias\\EmailValidator\\Parser\\LocalPart' => $vendorDir . '/egulias/email-validator/EmailValidator/Parser/LocalPart.php',
    'Egulias\\EmailValidator\\Parser\\Parser' => $vendorDir . '/egulias/email-validator/EmailValidator/Parser/Parser.php',
    'Egulias\\EmailValidator\\Validation\\DNSCheckValidation' => $vendorDir . '/egulias/email-validator/EmailValidator/Validation/DNSCheckValidation.php',
    'Egulias\\EmailValidator\\Validation\\EmailValidation' => $vendorDir . '/egulias/email-validator/EmailValidator/Validation/EmailValidation.php',
    'Egulias\\EmailValidator\\Validation\\Error\\RFCWarnings' => $vendorDir . '/egulias/email-validator/EmailValidator/Validation/Error/RFCWarnings.php',
    'Egulias\\EmailValidator\\Validation\\Error\\SpoofEmail' => $vendorDir . '/egulias/email-validator/EmailValidator/Validation/Error/SpoofEmail.php',
    'Egulias\\EmailValidator\\Validation\\Exception\\EmptyValidationList' => $vendorDir . '/egulias/email-validator/EmailValidator/Validation/Exception/EmptyValidationList.php',
    'Egulias\\EmailValidator\\Validation\\MultipleErrors' => $vendorDir . '/egulias/email-validator/EmailValidator/Validation/MultipleErrors.php',
    'Egulias\\EmailValidator\\Validation\\MultipleValidationWithAnd' => $vendorDir . '/egulias/email-validator/EmailValidator/Validation/MultipleValidationWithAnd.php',
    'Egulias\\EmailValidator\\Validation\\NoRFCWarningsValidation' => $vendorDir . '/egulias/email-validator/EmailValidator/Validation/NoRFCWarningsValidation.php',
    'Egulias\\EmailValidator\\Validation\\RFCValidation' => $vendorDir . '/egulias/email-validator/EmailValidator/Validation/RFCValidation.php',
    'Egulias\\EmailValidator\\Validation\\SpoofCheckValidation' => $vendorDir . '/egulias/email-validator/EmailValidator/Validation/SpoofCheckValidation.php',
    'Egulias\\EmailValidator\\Warning\\AddressLiteral' => $vendorDir . '/egulias/email-validator/EmailValidator/Warning/AddressLiteral.php',
    'Egulias\\EmailValidator\\Warning\\CFWSNearAt' => $vendorDir . '/egulias/email-validator/EmailValidator/Warning/CFWSNearAt.php',
    'Egulias\\EmailValidator\\Warning\\CFWSWithFWS' => $vendorDir . '/egulias/email-validator/EmailValidator/Warning/CFWSWithFWS.php',
    'Egulias\\EmailValidator\\Warning\\Comment' => $vendorDir . '/egulias/email-validator/EmailValidator/Warning/Comment.php',
    'Egulias\\EmailValidator\\Warning\\DeprecatedComment' => $vendorDir . '/egulias/email-validator/EmailValidator/Warning/DeprecatedComment.php',
    'Egulias\\EmailValidator\\Warning\\DomainLiteral' => $vendorDir . '/egulias/email-validator/EmailValidator/Warning/DomainLiteral.php',
    'Egulias\\EmailValidator\\Warning\\DomainTooLong' => $vendorDir . '/egulias/email-validator/EmailValidator/Warning/DomainTooLong.php',
    'Egulias\\EmailValidator\\Warning\\EmailTooLong' => $vendorDir . '/egulias/email-validator/EmailValidator/Warning/EmailTooLong.php',
    'Egulias\\EmailValidator\\Warning\\IPV6BadChar' => $vendorDir . '/egulias/email-validator/EmailValidator/Warning/IPV6BadChar.php',
    'Egulias\\EmailValidator\\Warning\\IPV6ColonEnd' => $vendorDir . '/egulias/email-validator/EmailValidator/Warning/IPV6ColonEnd.php',
    'Egulias\\EmailValidator\\Warning\\IPV6ColonStart' => $vendorDir . '/egulias/email-validator/EmailValidator/Warning/IPV6ColonStart.php',
    'Egulias\\EmailValidator\\Warning\\IPV6Deprecated' => $vendorDir . '/egulias/email-validator/EmailValidator/Warning/IPV6Deprecated.php',
    'Egulias\\EmailValidator\\Warning\\IPV6DoubleColon' => $vendorDir . '/egulias/email-validator/EmailValidator/Warning/IPV6DoubleColon.php',
    'Egulias\\EmailValidator\\Warning\\IPV6GroupCount' => $vendorDir . '/egulias/email-validator/EmailValidator/Warning/IPV6GroupCount.php',
    'Egulias\\EmailValidator\\Warning\\IPV6MaxGroups' => $vendorDir . '/egulias/email-validator/EmailValidator/Warning/IPV6MaxGroups.php',
    'Egulias\\EmailValidator\\Warning\\LabelTooLong' => $vendorDir . '/egulias/email-validator/EmailValidator/Warning/LabelTooLong.php',
    'Egulias\\EmailValidator\\Warning\\LocalTooLong' => $vendorDir . '/egulias/email-validator/EmailValidator/Warning/LocalTooLong.php',
    'Egulias\\EmailValidator\\Warning\\NoDNSMXRecord' => $vendorDir . '/egulias/email-validator/EmailValidator/Warning/NoDNSMXRecord.php',
    'Egulias\\EmailValidator\\Warning\\ObsoleteDTEXT' => $vendorDir . '/egulias/email-validator/EmailValidator/Warning/ObsoleteDTEXT.php',
    'Egulias\\EmailValidator\\Warning\\QuotedPart' => $vendorDir . '/egulias/email-validator/EmailValidator/Warning/QuotedPart.php',
    'Egulias\\EmailValidator\\Warning\\QuotedString' => $vendorDir . '/egulias/email-validator/EmailValidator/Warning/QuotedString.php',
    'Egulias\\EmailValidator\\Warning\\TLD' => $vendorDir . '/egulias/email-validator/EmailValidator/Warning/TLD.php',
    'Egulias\\EmailValidator\\Warning\\Warning' => $vendorDir . '/egulias/email-validator/EmailValidator/Warning/Warning.php',
    'FastRoute\\BadRouteException' => $vendorDir . '/nikic/fast-route/src/BadRouteException.php',
    'FastRoute\\DataGenerator' => $vendorDir . '/nikic/fast-route/src/DataGenerator.php',
    'FastRoute\\DataGenerator\\CharCountBased' => $vendorDir . '/nikic/fast-route/src/DataGenerator/CharCountBased.php',
    'FastRoute\\DataGenerator\\GroupCountBased' => $vendorDir . '/nikic/fast-route/src/DataGenerator/GroupCountBased.php',
    'FastRoute\\DataGenerator\\GroupPosBased' => $vendorDir . '/nikic/fast-route/src/DataGenerator/GroupPosBased.php',
    'FastRoute\\DataGenerator\\MarkBased' => $vendorDir . '/nikic/fast-route/src/DataGenerator/MarkBased.php',
    'FastRoute\\DataGenerator\\RegexBasedAbstract' => $vendorDir . '/nikic/fast-route/src/DataGenerator/RegexBasedAbstract.php',
    'FastRoute\\Dispatcher' => $vendorDir . '/nikic/fast-route/src/Dispatcher.php',
    'FastRoute\\Dispatcher\\CharCountBased' => $vendorDir . '/nikic/fast-route/src/Dispatcher/CharCountBased.php',
    'FastRoute\\Dispatcher\\GroupCountBased' => $vendorDir . '/nikic/fast-route/src/Dispatcher/GroupCountBased.php',
    'FastRoute\\Dispatcher\\GroupPosBased' => $vendorDir . '/nikic/fast-route/src/Dispatcher/GroupPosBased.php',
    'FastRoute\\Dispatcher\\MarkBased' => $vendorDir . '/nikic/fast-route/src/Dispatcher/MarkBased.php',
    'FastRoute\\Dispatcher\\RegexBasedAbstract' => $vendorDir . '/nikic/fast-route/src/Dispatcher/RegexBasedAbstract.php',
    'FastRoute\\Route' => $vendorDir . '/nikic/fast-route/src/Route.php',
    'FastRoute\\RouteCollector' => $vendorDir . '/nikic/fast-route/src/RouteCollector.php',
    'FastRoute\\RouteParser' => $vendorDir . '/nikic/fast-route/src/RouteParser.php',
    'FastRoute\\RouteParser\\Std' => $vendorDir . '/nikic/fast-route/src/RouteParser/Std.php',
    'Firebase\\JWT\\BeforeValidException' => $vendorDir . '/firebase/php-jwt/src/BeforeValidException.php',
    'Firebase\\JWT\\ExpiredException' => $vendorDir . '/firebase/php-jwt/src/ExpiredException.php',
    'Firebase\\JWT\\JWT' => $vendorDir . '/firebase/php-jwt/src/JWT.php',
    'Firebase\\JWT\\SignatureInvalidException' => $vendorDir . '/firebase/php-jwt/src/SignatureInvalidException.php',
    'PHPMailer\\PHPMailer\\Exception' => $vendorDir . '/phpmailer/phpmailer/src/Exception.php',
    'PHPMailer\\PHPMailer\\OAuth' => $vendorDir . '/phpmailer/phpmailer/src/OAuth.php',
    'PHPMailer\\PHPMailer\\PHPMailer' => $vendorDir . '/phpmailer/phpmailer/src/PHPMailer.php',
    'PHPMailer\\PHPMailer\\POP3' => $vendorDir . '/phpmailer/phpmailer/src/POP3.php',
    'PHPMailer\\PHPMailer\\SMTP' => $vendorDir . '/phpmailer/phpmailer/src/SMTP.php',
    'PhpOption\\LazyOption' => $vendorDir . '/phpoption/phpoption/src/PhpOption/LazyOption.php',
    'PhpOption\\None' => $vendorDir . '/phpoption/phpoption/src/PhpOption/None.php',
    'PhpOption\\Option' => $vendorDir . '/phpoption/phpoption/src/PhpOption/Option.php',
    'PhpOption\\Some' => $vendorDir . '/phpoption/phpoption/src/PhpOption/Some.php',
    'Pimple\\Container' => $vendorDir . '/pimple/pimple/src/Pimple/Container.php',
    'Pimple\\Exception\\ExpectedInvokableException' => $vendorDir . '/pimple/pimple/src/Pimple/Exception/ExpectedInvokableException.php',
    'Pimple\\Exception\\FrozenServiceException' => $vendorDir . '/pimple/pimple/src/Pimple/Exception/FrozenServiceException.php',
    'Pimple\\Exception\\InvalidServiceIdentifierException' => $vendorDir . '/pimple/pimple/src/Pimple/Exception/InvalidServiceIdentifierException.php',
    'Pimple\\Exception\\UnknownIdentifierException' => $vendorDir . '/pimple/pimple/src/Pimple/Exception/UnknownIdentifierException.php',
    'Pimple\\Psr11\\Container' => $vendorDir . '/pimple/pimple/src/Pimple/Psr11/Container.php',
    'Pimple\\Psr11\\ServiceLocator' => $vendorDir . '/pimple/pimple/src/Pimple/Psr11/ServiceLocator.php',
    'Pimple\\ServiceIterator' => $vendorDir . '/pimple/pimple/src/Pimple/ServiceIterator.php',
    'Pimple\\ServiceProviderInterface' => $vendorDir . '/pimple/pimple/src/Pimple/ServiceProviderInterface.php',
    'Pimple\\Tests\\Fixtures\\Invokable' => $vendorDir . '/pimple/pimple/src/Pimple/Tests/Fixtures/Invokable.php',
    'Pimple\\Tests\\Fixtures\\NonInvokable' => $vendorDir . '/pimple/pimple/src/Pimple/Tests/Fixtures/NonInvokable.php',
    'Pimple\\Tests\\Fixtures\\PimpleServiceProvider' => $vendorDir . '/pimple/pimple/src/Pimple/Tests/Fixtures/PimpleServiceProvider.php',
    'Pimple\\Tests\\Fixtures\\Service' => $vendorDir . '/pimple/pimple/src/Pimple/Tests/Fixtures/Service.php',
    'Pimple\\Tests\\PimpleServiceProviderInterfaceTest' => $vendorDir . '/pimple/pimple/src/Pimple/Tests/PimpleServiceProviderInterfaceTest.php',
    'Pimple\\Tests\\PimpleTest' => $vendorDir . '/pimple/pimple/src/Pimple/Tests/PimpleTest.php',
    'Pimple\\Tests\\Psr11\\ContainerTest' => $vendorDir . '/pimple/pimple/src/Pimple/Tests/Psr11/ContainerTest.php',
    'Pimple\\Tests\\Psr11\\ServiceLocatorTest' => $vendorDir . '/pimple/pimple/src/Pimple/Tests/Psr11/ServiceLocatorTest.php',
    'Pimple\\Tests\\ServiceIteratorTest' => $vendorDir . '/pimple/pimple/src/Pimple/Tests/ServiceIteratorTest.php',
    'Psr\\Container\\ContainerExceptionInterface' => $vendorDir . '/psr/container/src/ContainerExceptionInterface.php',
    'Psr\\Container\\ContainerInterface' => $vendorDir . '/psr/container/src/ContainerInterface.php',
    'Psr\\Container\\NotFoundExceptionInterface' => $vendorDir . '/psr/container/src/NotFoundExceptionInterface.php',
    'Psr\\Http\\Message\\MessageInterface' => $vendorDir . '/psr/http-message/src/MessageInterface.php',
    'Psr\\Http\\Message\\RequestInterface' => $vendorDir . '/psr/http-message/src/RequestInterface.php',
    'Psr\\Http\\Message\\ResponseInterface' => $vendorDir . '/psr/http-message/src/ResponseInterface.php',
    'Psr\\Http\\Message\\ServerRequestInterface' => $vendorDir . '/psr/http-message/src/ServerRequestInterface.php',
    'Psr\\Http\\Message\\StreamInterface' => $vendorDir . '/psr/http-message/src/StreamInterface.php',
    'Psr\\Http\\Message\\UploadedFileInterface' => $vendorDir . '/psr/http-message/src/UploadedFileInterface.php',
    'Psr\\Http\\Message\\UriInterface' => $vendorDir . '/psr/http-message/src/UriInterface.php',
    'Slim\\App' => $vendorDir . '/slim/slim/Slim/App.php',
    'Slim\\CallableResolver' => $vendorDir . '/slim/slim/Slim/CallableResolver.php',
    'Slim\\CallableResolverAwareTrait' => $vendorDir . '/slim/slim/Slim/CallableResolverAwareTrait.php',
    'Slim\\Collection' => $vendorDir . '/slim/slim/Slim/Collection.php',
    'Slim\\Container' => $vendorDir . '/slim/slim/Slim/Container.php',
    'Slim\\DefaultServicesProvider' => $vendorDir . '/slim/slim/Slim/DefaultServicesProvider.php',
    'Slim\\DeferredCallable' => $vendorDir . '/slim/slim/Slim/DeferredCallable.php',
    'Slim\\Exception\\ContainerException' => $vendorDir . '/slim/slim/Slim/Exception/ContainerException.php',
    'Slim\\Exception\\ContainerValueNotFoundException' => $vendorDir . '/slim/slim/Slim/Exception/ContainerValueNotFoundException.php',
    'Slim\\Exception\\InvalidMethodException' => $vendorDir . '/slim/slim/Slim/Exception/InvalidMethodException.php',
    'Slim\\Exception\\MethodNotAllowedException' => $vendorDir . '/slim/slim/Slim/Exception/MethodNotAllowedException.php',
    'Slim\\Exception\\NotFoundException' => $vendorDir . '/slim/slim/Slim/Exception/NotFoundException.php',
    'Slim\\Exception\\SlimException' => $vendorDir . '/slim/slim/Slim/Exception/SlimException.php',
    'Slim\\Handlers\\AbstractError' => $vendorDir . '/slim/slim/Slim/Handlers/AbstractError.php',
    'Slim\\Handlers\\AbstractHandler' => $vendorDir . '/slim/slim/Slim/Handlers/AbstractHandler.php',
    'Slim\\Handlers\\Error' => $vendorDir . '/slim/slim/Slim/Handlers/Error.php',
    'Slim\\Handlers\\NotAllowed' => $vendorDir . '/slim/slim/Slim/Handlers/NotAllowed.php',
    'Slim\\Handlers\\NotFound' => $vendorDir . '/slim/slim/Slim/Handlers/NotFound.php',
    'Slim\\Handlers\\PhpError' => $vendorDir . '/slim/slim/Slim/Handlers/PhpError.php',
    'Slim\\Handlers\\Strategies\\RequestResponse' => $vendorDir . '/slim/slim/Slim/Handlers/Strategies/RequestResponse.php',
    'Slim\\Handlers\\Strategies\\RequestResponseArgs' => $vendorDir . '/slim/slim/Slim/Handlers/Strategies/RequestResponseArgs.php',
    'Slim\\Http\\Body' => $vendorDir . '/slim/slim/Slim/Http/Body.php',
    'Slim\\Http\\Cookies' => $vendorDir . '/slim/slim/Slim/Http/Cookies.php',
    'Slim\\Http\\Environment' => $vendorDir . '/slim/slim/Slim/Http/Environment.php',
    'Slim\\Http\\Headers' => $vendorDir . '/slim/slim/Slim/Http/Headers.php',
    'Slim\\Http\\Message' => $vendorDir . '/slim/slim/Slim/Http/Message.php',
    'Slim\\Http\\NonBufferedBody' => $vendorDir . '/slim/slim/Slim/Http/NonBufferedBody.php',
    'Slim\\Http\\Request' => $vendorDir . '/slim/slim/Slim/Http/Request.php',
    'Slim\\Http\\RequestBody' => $vendorDir . '/slim/slim/Slim/Http/RequestBody.php',
    'Slim\\Http\\Response' => $vendorDir . '/slim/slim/Slim/Http/Response.php',
    'Slim\\Http\\StatusCode' => $vendorDir . '/slim/slim/Slim/Http/StatusCode.php',
    'Slim\\Http\\Stream' => $vendorDir . '/slim/slim/Slim/Http/Stream.php',
    'Slim\\Http\\UploadedFile' => $vendorDir . '/slim/slim/Slim/Http/UploadedFile.php',
    'Slim\\Http\\Uri' => $vendorDir . '/slim/slim/Slim/Http/Uri.php',
    'Slim\\Interfaces\\CallableResolverInterface' => $vendorDir . '/slim/slim/Slim/Interfaces/CallableResolverInterface.php',
    'Slim\\Interfaces\\CollectionInterface' => $vendorDir . '/slim/slim/Slim/Interfaces/CollectionInterface.php',
    'Slim\\Interfaces\\Http\\CookiesInterface' => $vendorDir . '/slim/slim/Slim/Interfaces/Http/CookiesInterface.php',
    'Slim\\Interfaces\\Http\\EnvironmentInterface' => $vendorDir . '/slim/slim/Slim/Interfaces/Http/EnvironmentInterface.php',
    'Slim\\Interfaces\\Http\\HeadersInterface' => $vendorDir . '/slim/slim/Slim/Interfaces/Http/HeadersInterface.php',
    'Slim\\Interfaces\\InvocationStrategyInterface' => $vendorDir . '/slim/slim/Slim/Interfaces/InvocationStrategyInterface.php',
    'Slim\\Interfaces\\RouteGroupInterface' => $vendorDir . '/slim/slim/Slim/Interfaces/RouteGroupInterface.php',
    'Slim\\Interfaces\\RouteInterface' => $vendorDir . '/slim/slim/Slim/Interfaces/RouteInterface.php',
    'Slim\\Interfaces\\RouterInterface' => $vendorDir . '/slim/slim/Slim/Interfaces/RouterInterface.php',
    'Slim\\MiddlewareAwareTrait' => $vendorDir . '/slim/slim/Slim/MiddlewareAwareTrait.php',
    'Slim\\Routable' => $vendorDir . '/slim/slim/Slim/Routable.php',
    'Slim\\Route' => $vendorDir . '/slim/slim/Slim/Route.php',
    'Slim\\RouteGroup' => $vendorDir . '/slim/slim/Slim/RouteGroup.php',
    'Slim\\Router' => $vendorDir . '/slim/slim/Slim/Router.php',
    'Symfony\\Polyfill\\Ctype\\Ctype' => $vendorDir . '/symfony/polyfill-ctype/Ctype.php',
    'Symfony\\Polyfill\\Intl\\Idn\\Idn' => $vendorDir . '/symfony/polyfill-intl-idn/Idn.php',
    'Symfony\\Polyfill\\Mbstring\\Mbstring' => $vendorDir . '/symfony/polyfill-mbstring/Mbstring.php',
    'Symfony\\Polyfill\\Php72\\Php72' => $vendorDir . '/symfony/polyfill-php72/Php72.php',
);
