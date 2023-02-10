<?php

namespace Finller\AwsMediaConvert\Support;

use Illuminate\Contracts\Support\Arrayable;

/**
 * Default settings for an web optimized .mp4 Video
 */
class DefaultMediaConvertSettings implements Arrayable
{

    public function __construct(public array $settings)
    {
    }

    public static function make(string $FileInput, string $Destination): static
    {
        return new static(
            [
                'OutputGroups' => [
                    [
                        'CustomName' => 'MP4',
                        'Name' => 'File Group',
                        'Outputs' => [
                            [
                                'ContainerSettings' => [
                                    'Container' => 'MP4',
                                    'Mp4Settings' => [
                                        'CslgAtom' => 'INCLUDE',
                                        'FreeSpaceBox' => 'EXCLUDE',
                                        'MoovPlacement' => 'PROGRESSIVE_DOWNLOAD',
                                    ],
                                ],
                                'VideoDescription' => [
                                    'ScalingBehavior' => 'DEFAULT',
                                    'TimecodeInsertion' => 'DISABLED',
                                    'AntiAlias' => 'ENABLED',
                                    'Sharpness' => 50,
                                    'CodecSettings' => [
                                        'Codec' => 'H_264',
                                        'H264Settings' => [
                                            'InterlaceMode' => 'PROGRESSIVE',
                                            'NumberReferenceFrames' => 3,
                                            'Syntax' => 'DEFAULT',
                                            'Softness' => 0,
                                            'GopClosedCadence' => 1,
                                            'GopSize' => 90,
                                            'Slices' => 1,
                                            'GopBReference' => 'DISABLED',
                                            'MaxBitrate' => 8000000,
                                            'SlowPal' => 'DISABLED',
                                            'SpatialAdaptiveQuantization' => 'ENABLED',
                                            'TemporalAdaptiveQuantization' => 'ENABLED',
                                            'FlickerAdaptiveQuantization' => 'DISABLED',
                                            'EntropyEncoding' => 'CABAC',
                                            'FramerateControl' => 'INITIALIZE_FROM_SOURCE',
                                            'RateControlMode' => 'QVBR',
                                            'QvbrSettings' => [
                                                'QvbrQualityLevel' => 7,
                                                'QvbrQualityLevelFineTune' => 0,
                                            ],
                                            'CodecProfile' => 'MAIN',
                                            'Telecine' => 'NONE',
                                            'MinIInterval' => 0,
                                            'AdaptiveQuantization' => 'HIGH',
                                            'CodecLevel' => 'AUTO',
                                            'FieldEncoding' => 'PAFF',
                                            'SceneChangeDetect' => 'ENABLED',
                                            'QualityTuningLevel' => 'SINGLE_PASS',
                                            'FramerateConversionAlgorithm' => 'DUPLICATE_DROP',
                                            'UnregisteredSeiTimecode' => 'DISABLED',
                                            'GopSizeUnits' => 'FRAMES',
                                            'ParControl' => 'INITIALIZE_FROM_SOURCE',
                                            'NumberBFramesBetweenReferenceFrames' => 2,
                                            'RepeatPps' => 'DISABLED',
                                        ],
                                    ],
                                    'AfdSignaling' => 'NONE',
                                    'DropFrameTimecode' => 'ENABLED',
                                    'RespondToAfd' => 'NONE',
                                    'ColorMetadata' => 'INSERT',
                                ],
                                'AudioDescriptions' => [
                                    [
                                        'AudioTypeControl' => 'FOLLOW_INPUT',
                                        'CodecSettings' => [
                                            'Codec' => 'AAC',
                                            'AacSettings' => [
                                                'AudioDescriptionBroadcasterMix' => 'NORMAL',
                                                'Bitrate' => 96000,
                                                'RateControlMode' => 'CBR',
                                                'CodecProfile' => 'LC',
                                                'CodingMode' => 'CODING_MODE_2_0',
                                                'RawFormat' => 'NONE',
                                                'SampleRate' => 48000,
                                                'Specification' => 'MPEG4',
                                            ],
                                        ],
                                        'LanguageCodeControl' => 'FOLLOW_INPUT',
                                    ],
                                ],
                            ],
                        ],
                        'OutputGroupSettings' => [
                            'Type' => 'FILE_GROUP_SETTINGS',
                            'FileGroupSettings' => [
                                'Destination' => $Destination,
                            ],
                        ],
                    ],
                ],
                'AdAvailOffset' => 0,
                'Inputs' => [
                    [
                        'AudioSelectors' => [
                            'Audio Selector 1' => [
                                'Offset' => 0,
                                'DefaultSelection' => 'DEFAULT',
                                'ProgramSelection' => 1,
                            ],
                        ],
                        'VideoSelector' => [
                            'ColorSpace' => 'FOLLOW',
                        ],
                        'FilterEnable' => 'AUTO',
                        'PsiControl' => 'USE_PSI',
                        'FilterStrength' => 0,
                        'DeblockFilter' => 'DISABLED',
                        'DenoiseFilter' => 'DISABLED',
                        'TimecodeSource' => 'EMBEDDED',
                        'FileInput' => $FileInput,
                    ],
                ],
            ]
        );
    }

    public function addOutput(array $outputGroup): static
    {
        array_push($this->settings["OutputGroups"], $outputGroup);
        return $this;
    }

    public function addOutputWhen(mixed $condition, callable|array $outputGroup): static
    {
        if (!$condition) {
            return $this;
        }

        return $this->addOutput(is_callable($outputGroup) ? $outputGroup() : $outputGroup);
    }

    public function toArray(): array
    {
        return $this->settings;
    }
}
