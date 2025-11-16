"use client";

import { useLoading } from "../context/LoadingContext";
import { Header } from "./Header";
import Image from "next/image";
import { useState, useEffect } from "react";

export const LoadingOverlay = () => {
  const { isLoading } = useLoading();
  const slices = [0, 45, 90, 135, 180, 225, 270, 315];

  // バウンス中のスライス index
  const [jumpIndex, setJumpIndex] = useState<number>(0);

  useEffect(() => {
    const interval = setInterval(() => {
      setJumpIndex((prev) => (prev + 1) % slices.length); // 順番に0→1→…→7→0
    }, 500); // 0.5秒ごとに切り替え
    return () => clearInterval(interval);
  }, []);

  if (!isLoading) return null;

  return (
    <div className="fixed inset-0 z-50 flex flex-col text-green GeneralPurposeBg">
      <Header />
      <div className="flex flex-col items-center justify-center">
        <p className="text-5xl font-bold mb-20">Loading...</p>

        <div className="relative w-[280px] h-[280px] flex items-center justify-center rotate-clockwise">
          {slices.map((deg, index) => (
            <div
              key={index}
              className="absolute"
              style={{
                transform: `rotate(${deg}deg) translateY(-82px)`,
                transformOrigin: "center center",
              }}
            >
              {/* 順番にバウンス */}
              <div className={index === jumpIndex ? "bounce" : ""}>
                <Image
                  src="/piza.svg"
                  alt={`Pizza Slice ${index + 1}`}
                  width={140}
                  height={140}
                  className="w-[140px] h-[140px]"
                />
              </div>
            </div>
          ))}
        </div>

        <p className="text-3xl font-bold mt-20 text-center">
          サイゼリヤの店名は、創業日である
          <br />
          2017月7日の誕生花「クチナシ」に由来します。
        </p>
      </div>

      <style jsx>{`
        @keyframes bounceAnim {
          0%, 100% {
            transform: translateY(0);
          }
          50% {
            transform: translateY(-15px);
          }
        }
        .bounce {
          animation: bounceAnim 0.5s ease-in-out;
        }
      `}</style>
    </div>
  );
};
