import AVFoundation
import AppKit
import QuartzCore

enum BrandVideoError: Error {
    case missingVideoTrack
    case cannotCreateCompositionTrack
    case cannotCreateExporter
    case missingLogo
}

guard CommandLine.arguments.count == 4 else {
    fputs("Usage: brand_video input.mp4 logo.png output.mp4\n", stderr)
    exit(2)
}

let inputURL = URL(fileURLWithPath: CommandLine.arguments[1])
let logoURL = URL(fileURLWithPath: CommandLine.arguments[2])
let outputURL = URL(fileURLWithPath: CommandLine.arguments[3])

let asset = AVURLAsset(url: inputURL)
let duration = try await asset.load(.duration)
let videoTracks = try await asset.loadTracks(withMediaType: .video)
guard let sourceVideo = videoTracks.first else { throw BrandVideoError.missingVideoTrack }

let naturalSize = try await sourceVideo.load(.naturalSize)
let transform = try await sourceVideo.load(.preferredTransform)
let transformed = naturalSize.applying(transform)
let renderSize = CGSize(width: abs(transformed.width), height: abs(transformed.height))
print("duration=\(CMTimeGetSeconds(duration)) natural=\(naturalSize) transform=\(transform) render=\(renderSize)")

let composition = AVMutableComposition()
guard let videoTrack = composition.addMutableTrack(withMediaType: .video, preferredTrackID: kCMPersistentTrackID_Invalid) else {
    throw BrandVideoError.cannotCreateCompositionTrack
}
try videoTrack.insertTimeRange(CMTimeRange(start: .zero, duration: duration), of: sourceVideo, at: .zero)

let audioTracks = try await asset.loadTracks(withMediaType: .audio)
if let sourceAudio = audioTracks.first,
   let audioTrack = composition.addMutableTrack(withMediaType: .audio, preferredTrackID: kCMPersistentTrackID_Invalid) {
    try audioTrack.insertTimeRange(CMTimeRange(start: .zero, duration: duration), of: sourceAudio, at: .zero)
}

let videoComposition = AVMutableVideoComposition()
videoComposition.renderSize = renderSize
videoComposition.frameDuration = CMTime(value: 1, timescale: 30)

let instruction = AVMutableVideoCompositionInstruction()
instruction.timeRange = CMTimeRange(start: .zero, duration: duration)
let layerInstruction = AVMutableVideoCompositionLayerInstruction(assetTrack: videoTrack)
layerInstruction.setTransform(transform, at: .zero)
instruction.layerInstructions = [layerInstruction]
videoComposition.instructions = [instruction]

let parentLayer = CALayer()
parentLayer.frame = CGRect(origin: .zero, size: renderSize)
let videoLayer = CALayer()
videoLayer.frame = parentLayer.frame
parentLayer.addSublayer(videoLayer)

let navy = NSColor(calibratedRed: 30/255, green: 58/255, blue: 138/255, alpha: 0.96).cgColor
let cyan = NSColor(calibratedRed: 50/255, green: 245/255, blue: 231/255, alpha: 1).cgColor

let topBand = CALayer()
topBand.frame = CGRect(x: 0, y: renderSize.height - 150, width: renderSize.width, height: 150)
topBand.backgroundColor = navy
parentLayer.addSublayer(topBand)

let accent = CALayer()
accent.frame = CGRect(x: 0, y: renderSize.height - 158, width: renderSize.width, height: 8)
accent.backgroundColor = cyan
parentLayer.addSublayer(accent)

guard let logo = NSImage(contentsOf: logoURL) else { throw BrandVideoError.missingLogo }
let logoLayer = CALayer()
logoLayer.contents = logo
logoLayer.contentsGravity = .resizeAspect
logoLayer.frame = CGRect(x: 28, y: renderSize.height - 125, width: 250, height: 92)
parentLayer.addSublayer(logoLayer)

let productText = CATextLayer()
productText.string = "LINGUISTIC DECODER"
productText.font = CGFont("Arial-BoldMT" as CFString)
productText.fontSize = 18
productText.foregroundColor = NSColor.white.cgColor
productText.alignmentMode = .right
productText.contentsScale = 2
productText.frame = CGRect(x: 285, y: renderSize.height - 94, width: renderSize.width - 315, height: 30)
parentLayer.addSublayer(productText)

let footer = CALayer()
footer.frame = CGRect(x: 0, y: 0, width: renderSize.width, height: 112)
footer.backgroundColor = navy
parentLayer.addSublayer(footer)

let footerText = CATextLayer()
footerText.string = "Real clarity. Not fake certainty."
footerText.font = CGFont("Arial-BoldMT" as CFString)
footerText.fontSize = 24
footerText.foregroundColor = NSColor.white.cgColor
footerText.alignmentMode = .center
footerText.contentsScale = 2
footerText.frame = CGRect(x: 24, y: 38, width: renderSize.width - 48, height: 34)
parentLayer.addSublayer(footerText)

videoComposition.animationTool = AVVideoCompositionCoreAnimationTool(
    postProcessingAsVideoLayer: videoLayer,
    in: parentLayer
)

try? FileManager.default.removeItem(at: outputURL)
guard let exporter = AVAssetExportSession(asset: composition, presetName: AVAssetExportPresetHighestQuality) else {
    throw BrandVideoError.cannotCreateExporter
}
exporter.outputURL = outputURL
exporter.outputFileType = .mp4
exporter.videoComposition = videoComposition
exporter.shouldOptimizeForNetworkUse = true

await exporter.export()
if exporter.status != .completed {
    throw exporter.error ?? BrandVideoError.cannotCreateExporter
}

print("Created \(outputURL.path)")
