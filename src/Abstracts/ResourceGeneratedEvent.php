<?php
/**
 * Created by PhpStorm.
 * User: tony
 * Date: 12.03.19
 * Time: 14:55
 */

namespace Larapie\Generator\Abstracts;

use Larapie\Generator\Contracts\ResourceGenerationContract;
use Larapie\Generator\Support\Stub;

/**
 * Class ResourceGeneratedEvent
 * @package Larapie\Generator\Abstracts
 */
abstract class ResourceGeneratedEvent implements ResourceGenerationContract
{
    /**
     * @var string
     */
    protected $filePath;

    /**
     * @var Stub
     */
    protected $stub;

    /**
     * FileGeneratedEvent constructor.
     * @param string $filePath
     * @param Stub $stub
     * @param string $generationClass
     */
    public final function __construct(string $filePath, Stub $stub)
    {
        $this->filePath = $filePath;
        $this->stub = $stub;
    }

    /**
     * @return string
     */
    public function getFilePath(): string
    {
        return $this->filePath;
    }

    /**
     * @return Stub
     */
    public function getStub(): Stub
    {
        return $this->stub;
    }

    /**
     * @return string|null
     */
    public function getNamespace(): ?string
    {
        return $this->getStubOption("namespace");
    }

    /**
     * @return string|null
     */
    public function getClassName(): ?string
    {
        return $this->getStubOption("class");
    }

    /**
     * @return string|null
     */
    public function getModuleName(): string
    {
        return $this->getStubOption("module");
    }

    public function getStubOption(string $option)
    {
        return $this->getStub()->getOptions()[strtoupper($option)] ?? null;
    }

}
